<?php

namespace jungleminds\nethooks\web\twig\variables;

use Craft;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Output\RenderedContentInterface;

class NethooksVariable
{

    public CommonMarkConverter $markConverter;

    public function __construct($config = [])
    {
        $this->markConverter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false
        ]);
    }

    /**
     * Returns markdown for badge
     *
     * @param $badge
     * @return RenderedContentInterface|string
     * @throws CommonMarkException
     */
    public function getBadge($badge)
    {
        try {
            return $this->markConverter->convert($badge);
        } catch (\Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
            return "";
        }
    }
}