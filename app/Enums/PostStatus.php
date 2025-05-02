<?php
/**
 *Created by PhpStorm
 *Created at ৫/১/২২ ৫:০৪ PM
 */

namespace App\Enums;


class PostStatus
{
    public const PUBLISHED = 1;
    public const DRAFT = 2;
    public const PENDING = 3;

    public const POST_STATUS = [
      "1" => "Published",
        "2" => "Draft",
        "3" => "Pending"
    ];
}