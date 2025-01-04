<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector;
use Rector\Strict\Rector\If_\BooleanInIfConditionRuleFixerRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\CodingStyle\Rector\Property\SplitGroupedPropertiesRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncToMethodCallRector;
use Rector\Strict\Rector\BooleanNot\BooleanInBooleanNotRuleFixerRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector;
use Rector\Instanceof_\Rector\Ternary\FlipNegatedTernaryInstanceofRector;
use Rector\Strict\Rector\Ternary\BooleanInTernaryOperatorRuleFixerRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
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
        CallUserFuncArrayToVariadicRector::class,
        CallUserFuncToMethodCallRector::class,
        CatchExceptionNameMatchingTypeRector::class,
        ConsistentImplodeRector::class,
        CountArrayToEmptyArrayComparisonRector::class,
        DisallowedEmptyRuleFixerRector::class,
        FlipNegatedTernaryInstanceofRector::class,
        FuncCallToConstFetchRector::class,
        RemoveExtraParametersRector::class,
        RenameForeachValueVariableToMatchExprVariableRector::class,
        RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        VarToPublicPropertyRector::class,
        SplitGroupedPropertiesRector::class,
        SplitDoubleAssignRector::class,
        NewlineAfterStatementRector::class,
    ])
    ->withTypeCoverageLevel(0);
