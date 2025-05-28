<?php declare(strict_types=1);

namespace App\LLM;

use App\LLM\Contracts\IDescribeImage;
use App\LLM\Contracts\ISelectCategory;
use App\LLM\Contracts\IShortText;
use App\LLM\Models\DeepseekR1;
use App\LLM\Models\Llava;
use Illuminate\Support\Str;

class ModelFactory
{
    public static function questionModel(): ISelectCategory|IShortText
    {
        $environment = config('llm.environment');

        if ($environment !== 'ollama') {
            throw new \Exception('Invalid environment. Expected "ollama".');
        }

        $model = config('llm.question_model');

        if (!Str::of($model)->startsWith('deepseek-r1'))
        {
            trigger_error("Possible unsupported model detected. Expected \"deepseek-r1\" prefix, received \"{$model}\".", E_USER_WARNING);
        }

        // NOTE: use the Deepseek-R1 model
        $objModel = new DeepseekR1();
        $objModel->setModel($model);

        return $objModel;
    }

    public static function imageModel(): IDescribeImage
    {
        $environment = config('llm.environment');

        if ($environment !== 'ollama') {
            throw new \Exception('Invalid environment. Expected "ollama".');
        }

        $model = config('llm.image_model');

        if (!Str::of($model)->startsWith('llava'))
        {
            trigger_error("Possible unsupported model detected. Expected \"llava\" prefix, received \"{$model}\".", E_USER_WARNING);
        }

        // NOTE: use the Llava model
        $objModel = new Llava();
        $objModel->setModel($model);

        return $objModel;
    }
}