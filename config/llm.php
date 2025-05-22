<?php

return [
    'environment' => env('LLM_ENVIRONMENT', 'ollama'),
    'question_model' => env('LLM_QUESTION_MODEL', 'deepseek-r1'),
    'image_model' => env('LLM_IMAGE_MODEL', 'llava'),
];
