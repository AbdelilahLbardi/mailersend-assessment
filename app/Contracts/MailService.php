<?php


namespace App\Contracts;


interface MailService
{
    /**
     * @param $data
     * @return mixed
     */
    public function create($data);
}