<?php
namespace App\Controller;

use App\Core\Controller;
use App\Core\Model\Collection;
use App\Model\BlogPost;
use App\Model\LandingPageContent;
use App\Model\SocialLink;

class Index extends Controller
{
    public function handle(): void
    {
        $this->render('home', [
            'episodes' => $this->getEpisodes(),
            'blogPosts' => $this->getBlogPosts(),
            'heroes' => $this->getHeroes(),
            'landingContent' => $this->getLandingContent(),
            'socialLinks' => $this->getSocialLinks(),
        ]);
    }

    /**
     * Retrieve landing page content from database
     *
     * @return array
     */
    protected function getLandingContent(): array
    {
        return LandingPageContent::getAllSections();
    }

    /**
     * Retrieve social links collection
     *
     * @return Collection
     */
    protected function getSocialLinks(): Collection
    {
        $socialLinksCollection = (new SocialLink())
            ->getCollection()
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            ->addFilter(['enabled' => 1])
            ->sort('display_order', 'ASC');

        return $socialLinksCollection;
    }

    /**
     * Retrieve heroes collection
     *
     * @return Collection
     */
    protected function getHeroes(): Collection
    {
        $heroesCollection = (new \App\Model\Hero())
            ->getCollection()
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            ->sort('name', 'ASC');

        return $heroesCollection;
    }

    /**
     * Retrieve blog posts collection
     *
     * @return Collection
     */
    protected function getBlogPosts(): Collection
    {
        $blogPostsCollection = (new BlogPost())
            ->getCollection()
            ->addFilter(['published' => 1])
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            ->sort('created_at', 'DESC')
            ->setPageSize(5);

        return $blogPostsCollection;
    }

    /**
     * Retrieve episodes collection
     *
     * @return Collection
     */
    protected function getEpisodes(): Collection
    {
        $episodesCollection = (new \App\Model\Episode())
            ->getCollection()
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            ->addFilter(['status' => 1])
            ->sort('created_at', 'DESC');

        return $episodesCollection;
    }


}