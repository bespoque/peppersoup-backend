<?php

function stringOf(\Throwable $e): string
{
    return get_class($e).": " .$e->getMessage()." Line: ".$e->getLine()." File: ".$e->getFile();
}

