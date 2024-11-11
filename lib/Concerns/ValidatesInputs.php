<?php

namespace Forge\Concerns;

use Illuminate\Console\Concerns\HasParameters;
use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Support\Facades\Validator;


trait ValidatesInputs {
    use HasParameters, InteractsWithIO;
    /**
     * @return void
     * @param array<int,mixed> $optionRules
     * @param array<int,mixed> $argumentRules
     */
    protected function validate(array $optionRules, array $argumentRules): array
    {
        if (!empty($optionRules)) {
            $options = $this->validateOptions($optionRules);
        } else {
            $options = $this->options();
        }

        if (!empty($argumentRules)) {
            $arguments = $this->validateArguments($argumentRules);
        } else {
            $arguments = $this->arguments();
        }


        return [ $options,  $arguments ];
    }
    /**
     * @param array<int,mixed> $rules
     */
    protected function validateOptions(array $rules): array
    {
        $validator = Validator::make($this->options(), $rules);

        if ($validator->fails()) {
            collect($validator->errors()->all())->each(fn($error) => $this->error($error));
            exit(1);
        }

        return $validator->validated();
    }
    /**
     * @param array<int,mixed> $rules
     */
    protected function validateArguments(array $rules): array
    {
        $validator = Validator::make($this->arguments(), $rules);

        if ($validator->fails()) {
            collect($validator->errors()->all())->each(fn($error) => $this->error($error));
            exit(1);
        }

        return $validator->validated();
    }
}
