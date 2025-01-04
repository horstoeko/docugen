<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector;
use Rector\Strict\Rector\If_\BooleanInIfConditionRuleFixerRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncToMethodCallRector;
use Rector\Strict\Rector\BooleanNot\BooleanInBooleanNotRuleFixerRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Instanceof_\Rector\Ternary\FlipNegatedTernaryInstanceofRector;
use Rector\Strict\Rector\Ternary\BooleanInTernaryOperatorRuleFixerRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/../examples',
        __DIR__ . '/../make',
        __DIR__ . '/../src',
        __DIR__ . '/../tests',
    ])
    ->withSkip([
        __DIR__ . '/../src/entities',
        __DIR__ . '/../src/codelistsenum',
    ])
    ->withSkip([
        RemoveUselessParamTagRector::class,
        RemoveUselessReturnTagRector::class,
    ])
    ->withPhp73Sets()
    ->withSets([
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
    ])
    ->withConfiguredRule(EncapsedStringsToSprintfRector::class, [
        'always' => true,
    ])
    ->withRules([
        BooleanInBooleanNotRuleFixerRector::class,
        BooleanInIfConditionRuleFixerRector::class,
        BooleanInTernaryOperatorRuleFixerRector::class,
        DisallowedEmptyRuleFixerRector::class,
        FuncCallToConstFetchRector::class,
        RemoveExtraParametersRector::class,
        RenameForeachValueVariableToMatchExprVariableRector::class,
        RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        VarToPublicPropertyRector::class,
        FlipNegatedTernaryInstanceofRector::class,
        ConsistentImplodeRector::class,
        CallUserFuncToMethodCallRector::class,
    ])
    ->withTypeCoverageLevel(0);
