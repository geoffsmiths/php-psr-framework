<?php

namespace App\Core\Service\Twig;

use Twig\Cache\CacheInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\LoaderInterface;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\TokenParser\TokenParserInterface;

/**
 * Stores the Twig configuration.
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface EnvironmentInterface
{
    /**
     * Enables debugging mode.
     */
    public function enableDebug();

    /**
     * Disables debugging mode.
     */
    public function disableDebug();

    /**
     * Checks if debug mode is enabled.
     * @return bool true if debug mode is enabled, false otherwise
     */
    public function isDebug();

    /**
     * Enables the auto_reload option.
     */
    public function enableAutoReload();

    /**
     * Disables the auto_reload option.
     */
    public function disableAutoReload();

    /**
     * Checks if the auto_reload option is enabled.
     * @return bool true if auto_reload is enabled, false otherwise
     */
    public function isAutoReload();

    /**
     * Enables the strict_variables option.
     */
    public function enableStrictVariables();

    /**
     * Disables the strict_variables option.
     */
    public function disableStrictVariables();

    /**
     * Checks if the strict_variables option is enabled.
     * @return bool true if strict_variables is enabled, false otherwise
     */
    public function isStrictVariables();

    /**
     * Gets the current cache implementation.
     *
     * @param bool $original Whether to return the original cache option or the real cache instance
     *
     * @return CacheInterface|string|false A Twig\Cache\CacheInterface implementation,
     *                                     an absolute path to the compiled templates,
     *                                     or false to disable cache
     */
    public function getCache($original = true);

    /**
     * Sets the current cache implementation.
     *
     * @param CacheInterface|string|false $cache A Twig\Cache\CacheInterface implementation,
     *                                           an absolute path to the compiled templates,
     *                                           or false to disable cache
     */
    public function setCache($cache);

    /**
     * Gets the template class associated with the given string.
     * The generated template class is based on the following parameters:
     *  * The cache key for the given template;
     *  * The currently enabled extensions;
     *  * Whether the Twig C extension is available or not;
     *  * PHP version;
     *  * Twig version;
     *  * Options with what environment was created.
     *
     * @param string $name    The name for which to calculate the template class name
     * @param int|null $index The index if it is an embedded template
     *
     * @internal
     */
    public function getTemplateClass(string $name, int $index = null): string;

    /**
     * Renders a template.
     *
     * @param string|TemplateWrapper $name The template name
     *
     * @throws LoaderError  When the template cannot be found
     * @throws SyntaxError  When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function render($name, array $context = []): string;

    /**
     * Displays a template.
     *
     * @param string|TemplateWrapper $name The template name
     *
     * @throws LoaderError  When the template cannot be found
     * @throws SyntaxError  When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function display($name, array $context = []): void;

    /**
     * Loads a template.
     *
     * @param string|TemplateWrapper $name The template name
     *
     * @throws LoaderError  When the template cannot be found
     * @throws RuntimeError When a previously generated cache is corrupted
     * @throws SyntaxError  When an error occurred during compilation
     */
    public function load($name): TemplateWrapper;

    /**
     * Loads a template internal representation.
     * This method is for internal use only and should never be called
     * directly.
     *
     * @param string $name The template name
     * @param int $index   The index if it is an embedded template
     *
     * @throws LoaderError  When the template cannot be found
     * @throws RuntimeError When a previously generated cache is corrupted
     * @throws SyntaxError  When an error occurred during compilation
     * @internal
     */
    public function loadTemplate(string $cls, string $name, int $index = null): Template;

    /**
     * Creates a template from source.
     * This method should not be used as a generic way to load templates.
     *
     * @param string $template The template source
     * @param string $name     An optional name of the template to be used in error messages
     *
     * @throws LoaderError When the template cannot be found
     * @throws SyntaxError When an error occurred during compilation
     */
    public function createTemplate(string $template, string $name = null): TemplateWrapper;

    /**
     * Returns true if the template is still fresh.
     * Besides checking the loader for freshness information,
     * this method also checks if the enabled extensions have
     * not changed.
     *
     * @param int $time The last modification time of the cached template
     */
    public function isTemplateFresh(string $name, int $time): bool;

    /**
     * Tries to load a template consecutively from an array.
     * Similar to load() but it also accepts instances of \Twig\Template and
     * \Twig\TemplateWrapper, and an array of templates where each is tried to be loaded.
     *
     * @param string|TemplateWrapper|array $names A template or an array of templates to try consecutively
     *
     * @throws LoaderError When none of the templates can be found
     * @throws SyntaxError When an error occurred during compilation
     */
    public function resolveTemplate($names): TemplateWrapper;

    public function setLexer(Lexer $lexer);

    /**
     * @throws SyntaxError When the code is syntactically wrong
     */
    public function tokenize(Source $source): TokenStream;

    public function setParser(Parser $parser);

    /**
     * Converts a token stream to a node tree.
     * @throws SyntaxError When the token stream is syntactically or semantically wrong
     */
    public function parse(TokenStream $stream): ModuleNode;

    public function setCompiler(Compiler $compiler);

    /**
     * Compiles a node and returns the PHP code.
     */
    public function compile(Node $node): string;

    /**
     * Compiles a template source code.
     * @throws SyntaxError When there was an error during tokenizing, parsing or compiling
     */
    public function compileSource(Source $source): string;

    public function setLoader(LoaderInterface $loader);

    public function getLoader(): LoaderInterface;

    public function setCharset(string $charset);

    public function getCharset(): string;

    public function hasExtension(string $class): bool;

    public function addRuntimeLoader(RuntimeLoaderInterface $loader);

    public function getExtension(string $class): ExtensionInterface;

    /**
     * Returns the runtime implementation of a Twig element (filter/function/test).
     *
     * @param string $class A runtime class name
     *
     * @return object The runtime implementation
     * @throws RuntimeError When the template cannot be found
     */
    public function getRuntime(string $class);

    public function addExtension(ExtensionInterface $extension);

    /**
     * @param ExtensionInterface[] $extensions An array of extensions
     */
    public function setExtensions(array $extensions);

    /**
     * @return ExtensionInterface[] An array of extensions (keys are for internal usage only and should not be relied on)
     */
    public function getExtensions(): array;

    public function addTokenParser(TokenParserInterface $parser);

    /**
     * @return TokenParserInterface[]
     * @internal
     */
    public function getTokenParsers(): array;

    /**
     * @return TokenParserInterface[]
     * @internal
     */
    public function getTags(): array;

    public function addNodeVisitor(NodeVisitorInterface $visitor);

    /**
     * @return NodeVisitorInterface[]
     * @internal
     */
    public function getNodeVisitors(): array;

    public function addFilter(TwigFilter $filter);

    /**
     * @internal
     */
    public function getFilter(string $name): ?TwigFilter;

    public function registerUndefinedFilterCallback(callable $callable);

    /**
     * Gets the registered Filters.
     * Be warned that this method cannot return filters defined with registerUndefinedFilterCallback.
     * @return TwigFilter[]
     * @see registerUndefinedFilterCallback
     * @internal
     */
    public function getFilters(): array;

    public function addTest(TwigTest $test);

    /**
     * @return TwigTest[]
     * @internal
     */
    public function getTests(): array;

    /**
     * @internal
     */
    public function getTest(string $name): ?TwigTest;

    public function addFunction(TwigFunction $function);

    /**
     * @internal
     */
    public function getFunction(string $name): ?TwigFunction;

    public function registerUndefinedFunctionCallback(callable $callable);

    /**
     * Gets registered functions.
     * Be warned that this method cannot return functions defined with registerUndefinedFunctionCallback.
     * @return TwigFunction[]
     * @see registerUndefinedFunctionCallback
     * @internal
     */
    public function getFunctions(): array;

    /**
     * Registers a Global.
     * New globals can be added before compiling or rendering a template;
     * but after, you can only update existing globals.
     *
     * @param mixed $value The global value
     */
    public function addGlobal(string $name, $value);

    /**
     * @internal
     */
    public function getGlobals(): array;

    public function mergeGlobals(array $context): array;

    /**
     * @internal
     */
    public function getUnaryOperators(): array;

    /**
     * @internal
     */
    public function getBinaryOperators(): array;
}
