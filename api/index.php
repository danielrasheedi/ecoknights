<?php

/**
 * Serverless entry point for Vercel.
 * Every non-static request is routed here (see vercel.json) and handed to Laravel.
 */
require __DIR__ . '/../public/index.php';
