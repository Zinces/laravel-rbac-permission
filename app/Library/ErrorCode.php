<?php
/**
 * User: gedongdong@100tal.com
 * Date: 2019/1/31 下午8:01
 */

namespace App\Library;


class ErrorCode
{
    const OK = 0;

    const BAD_REQUEST = 1000;

    const SQL_ERROR = 4000;

    const FORBIDDEN = 4003;

    const SERVER_ERROR = 5000;
}