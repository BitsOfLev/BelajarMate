<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Banned Words List
    |--------------------------------------------------------------------------
    | Words or phrases that will flag a blog post or comment for admin review.
    */

    'words' => [

        // Profanity / vulgar language
        'profanity' => [
            'fuck',
            'shit',
            'bitch',
            'asshole',
            'damn',
            'crap',
            'dick',
            'piss',
            'cunt',
        ],

        // Hate speech / discriminatory language
        'hate_speech' => [
            'nigger',
            'fag',
            'slut',
            'retard',
            'kike',
            'chink',
            'spic',
        ],

        // Threats / violence
        'threats' => [
            'kill',
            'stab',
            'shoot',
            'bomb',
            'attack',
            'terrorist',
            'killer',
            'murder',
        ],

        // Sexual content / NSFW
        'sexual' => [
            'porn',
            'xxx',
            'sex',
            'nude',
            'hardcore',
        ],

        // Drugs / illegal substances
        'drugs' => [
            'cocaine',
            'heroin',
            'meth',
            'weed',
            'ecstasy',
            'marijuana',
        ],

        // Offensive slang / casual insults (optional)
        'slang' => [
            'stupid',
            'idiot',
            'dumb',
            'moron',
        ],

        // Dangerous phrases
        'phrases' => [
            'go die',
            'kill yourself',
            'i hate you',
        ],
    ],
];

