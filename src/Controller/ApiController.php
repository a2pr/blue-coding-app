<?php

namespace App\Controller;

use App\Entity\UrlEntry;
use App\Entity\UrlEvents;
use App\Repository\UrlEntryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    /**
     * @Route("/{shortUrl}", name="api_short", methods={"GET"})
     */
    public function index(string $shortUrl, UrlEntryRepository $urlEntryRepository): Response
    {
        ## process url to get from database.
        if (empty($shortUrl)) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try {
            $urlEntry = $urlEntryRepository->findOneBy(['shortUrl' => $shortUrl]);

            return new JsonResponse(['url' => $urlEntry->getOriginalUrl()], Response::HTTP_OK);
        } catch (Exception $exception) {

            return new JsonResponse(["message" => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/shortUrl", name="api_generate", methods={"POST"})
     */
    public function shortUrl(Request $request, EntityManagerInterface $entityManager): Response
    {
        ## process url to get from database.
        $content = json_decode($request->getContent(), true);
        if (empty($content["url"])) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }
        $originalUrl = $content["url"];
        try {
            $urlEntry = new UrlEntry();
            $urlEntry->setOriginalUrl($originalUrl);
            $urlEntry->setShortUrl("not set");

            $entityManager->persist($urlEntry);

            $entityManager->flush();

            $urlEntry->setShortUrl($this->processUrl($urlEntry->getId()));
            $newUrlEvent = new UrlEvents();
            $newUrlEvent->setUrlEntry($urlEntry);
            $entityManager->persist($newUrlEvent);
            $entityManager->flush();

            return new JsonResponse(
                [
                    "short url" =>
                        sprintf("this is your short url %s/%s", $request->getSchemeAndHttpHost(), $urlEntry->getShortUrl())
                ], Response::HTTP_OK);

        } catch (Exception $exception) {
            return new JsonResponse(["message" => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }


        /*return $this->redirect('https://google.com');*/
    }

    private function processUrl(int $urlEntryId)
    {
        $alphabet = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");

        if ($urlEntryId == 0) {
            return $alphabet[0];
        }

        $shortUrl = "";
        $alphabetLength = count($alphabet);
        $i = 0;
        while ($urlEntryId > 0) {
            $i++;
            $shortUrl .= $alphabet[$urlEntryId % $alphabetLength];
            $urlEntryId = floor($urlEntryId / $alphabetLength);
            if ($i == 100) die;
        }
        return strrev($shortUrl);

    }
}
