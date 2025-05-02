<?php


namespace App\Helpers;

use App\Entities\backend\PageSetup;
use App\Entities\backend\SelfDevelopmentFile;
use App\Entities\backend\WebSettings;
use App\Enums\PageContent;
use App\Enums\PageName;

class HelperClass
{
    public static function dateTimeConvert($dateTime = null)
    {
        return isset($dateTime) ? date('d-m-Y H:i:s', strtotime($dateTime)) : date('d-m-Y H:i:s');
    }

    public static function dateConvert($dateTime = null)
    {
        if (!empty($dateTime)) {
            return date('d-m-Y', strtotime($dateTime));
        } else {
            return $dateTime;
        }
    }

    public static function dateTimeFormatForDB($date = null)
    {
        if (!empty($date)) {
            return date("Y-m-d H:i:s", strtotime($date));
        } else {
            return $date;
        }
    }

    public static function dateFormatForDB($date = null)
    {
        if (!empty($date)) {
            return date("Y-m-d", strtotime($date));
        } else {
            return null;
        }
    }

    public static function dateConvertForMonth($dateTime = null)
    {
        if (!empty($dateTime)) {
            return date('d-M-Y', strtotime($dateTime));
        } else {
            return $dateTime;
        }
    }

    public static function timeFormatForDB($time = null)
    {
        if (!empty($time)) {
            return date("h:i:s", strtotime($time));
        } else {
            return $time;
        }
    }

    public static function timeFormat($time = null)
    {
        if (!empty($time)) {
            return date("h:i A", strtotime($time));
        } else {
            return $time;
        }
    }

    public static function validate_file_extension($givenExtension)
    {
        $allowedExtensions = ['docx', 'xlsx', 'jpg', 'jpeg', 'pdf'];

        if (!in_array($givenExtension, $allowedExtensions)) {
            return false;
        } else {
            return true;
        }
    }

    public static function get_setting($key, $default = null)
    {
        $webSetting = WebSettings::where('type', $key)->first();

        return $webSetting == null ? $default : $webSetting->value;
    }

    public static function newsletter()
    {
        $newsletter = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::NEWSLETTER)->first();
        return $newsletter;
    }

    public static function usefullink()
    {
        $usefullink = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::USEFULLINK)
            ->orderBy('content_serial', 'asc')->skip(0)->take(5)->get();
        return $usefullink;
    }

    public static function contactEmail()
    {
        $contact_email = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::BOTTOM_CONTACT_EMAIL)->first();
        return $contact_email;
    }

    public static function contactPhone()
    {
        $contact_phone = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::BOTTOM_CONTACT_PHONE)->get();
        return $contact_phone;
    }

    public static function contactSocial()
    {
        $contact_social = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::BOTTOM_CONTACT_SOCIAL_MEDIA)->get();
        return $contact_social;
    }

    public static function contactTopR8Img()
    {
        $contact_top_right_img = PageSetup::select('*')
            ->where('page_id', PageName::FOOTER)
            ->where('content_id', PageContent::TOP_IMG_RIGHT)->first();
        if (isset($contact_top_right_img)) {
            $top_right_img = SelfDevelopmentFile::where('parent_id', $contact_top_right_img->id)->where('parent_table', 'page_setup')->first();
            $contact_top_right_img->doc_file = isset($top_right_img->social_file_name) ? $top_right_img->social_file_name : '';
        }
        return $contact_top_right_img;
    }

    public static function random_str(int $length = 64, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}