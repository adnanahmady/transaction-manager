<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'vendor'
    ])
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR1' => true,
    '@PSR2' => true,
    '@PSR12' => true,
    '@PER-CS' => true,
    'no_empty_phpdoc' => true,
    'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
    'phpdoc_indent' => true,
    'blank_line_before_statement' => true,
    'no_trailing_comma_in_singleline' => true,
    'no_extra_blank_lines' => ['tokens' => [
        'attribute',
        'break',
        'case',
        'continue',
        'curly_brace_block',
        'default',
        'extra',
        'parenthesis_brace_block',
        'return',
        'square_brace_block',
        'switch',
        'throw',
        'use',
    ]],
    'trim_array_spaces' => true,
    'normalize_index_brace' => true,
    'phpdoc_var_annotation_correct_order' => true,
    'phpdoc_align' => true,
    'phpdoc_types' => true,
    'phpdoc_trim' => true,
    'phpdoc_order' => true,
    'phpdoc_summary' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_separation' => true,
    'no_blank_lines_after_phpdoc' => true,
    'return_assignment' => true,
    'php_unit_method_casing' => ['case' => 'snake_case'],
    'no_whitespace_in_blank_line' => true,
    'array_syntax' => ['syntax' => 'short'],
    'array_indentation' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'php_unit_test_annotation' => ['style' => 'prefix'],
    'single_blank_line_at_eof' => true,
    'multiline_comment_opening_closing' => true,
    'phpdoc_line_span' => ['method' => 'single'],
    'no_unused_imports' => true,
    'ordered_imports' => true,
    'type_declaration_spaces' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'void_return' => true,
    'no_useless_sprintf' => true,
    'single_line_comment_spacing' => true,
    'explicit_indirect_variable' => true,
    'concat_space' => ['spacing' => 'one'],
    'cast_spaces' => ['space' => 'single'],
    'binary_operator_spaces' => true,
    'method_chaining_indentation' => true,
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
])
    ->setFinder($finder)
    ->setRiskyAllowed(true);
