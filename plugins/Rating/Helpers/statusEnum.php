<?php
namespace Rating\Helpers;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approve';
    case REJECTED = 'reject';
}