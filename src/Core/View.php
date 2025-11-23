<?php
namespace App\Core;

class View implements Contract\ViewInterface
{
    const DEFAULT_TEMPLATE = 'index';
    const TEMPLATES_DIR = __DIR__ . '/../../views/';
    protected string $layoutsDir = __DIR__ . '/../../views/layout/';
    protected string $pageLayout = 'page.phtml';
    
    private string $template = self::DEFAULT_TEMPLATE;
    private array $params = [];

    public function __construct(
        private Controller $controller, 
        ?string $template = null, 
        array $params = []
    ) {
        $this->template = $template ?? self::DEFAULT_TEMPLATE;
        $this->params = $params;
    }

    /**
     * Magic method to get or set variables in the view.
     *
     * If only $var is provided, it returns the value of that variable.
     * If both $var and $value are provided, it sets the variable to the given value.
     *
     * @param string $var The variable name
     * @param mixed|null $value The value to set (optional)
     * @return mixed The value of the variable if getting, or the View instance if setting
     */
    public function __invoke(string $var, mixed $value = null): mixed
    {
        if ($value === null) {
            return $this->var($var);
        }

        $this->setVar($var, $value);

        return $this;
    }


    /**
     * Check if the minified CSS file exists.
     *
     * This method checks if the minified CSS file is present in the public directory.
     *
     * @return bool True if the minified CSS file exists, false otherwise
     */
    public static function hasMinifiedCSS(): bool
    {
        return file_exists(__DIR__ . '/../../public/css/minified.css');
    }

    /**
     * Get the template file path.
     *
     * This method returns the full path to the template file based on the current template name.
     *
     * @return string The full path to the template file
     */
    public function getTemplate(): string
    {
        return self::TEMPLATES_DIR . $this->template . '.phtml';
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * Render the view with the given parameters.
     *
     * This method will extract the parameters to variables and include the view file.
     * If $standalone is true, it will only include the view file without header/footer.
     *
     * @param array $params Parameters to pass to the view
     * @param bool $standalone Whether to render only the view file
     */
    public function render(array $params = [], bool $standalone = false): void
    {
        //ob_start();
            try{
            $this->params = array_merge($this->params, $params);
            //extract($this->params); //allow access to params as variables

            if ($standalone) { // If rendering standalone, include only the view file. f.e. ajax requests
                $viewFile = self::TEMPLATES_DIR . $this->template . '.phtml';
                    if (!file_exists($viewFile)) {
                    throw new \RuntimeException("View not found: $viewFile");
                }
                include $viewFile;
                return;
            }
            
            $layoutDir = $this->getLayoutDir();
            include $layoutDir . $this->pageLayout;
        } catch (\Throwable $e) {
            
            throw $e;
        }

        //$content = ob_end_clean();

        //echo $content;
    }

    /**
     *
     * @return Controller The controller instance
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     *
     * @return Request The request object
     */
    public function getRequest(): Request
    {
        return $this->getController()->getRequest();
    }

    /**
     * Get a variable from the view parameters.
     *
     * @param string $key The key of the variable to retrieve
     * @param mixed $default The default value to return if the key does not exist
     * @return mixed The value of the variable or the default value
     */
    public function var(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }

    /**
     * Set a variable in the view parameters.
     *
     * @param string $key The key of the variable to set
     * @param mixed $value The value to set for the variable
     */
    public function setVar(string $key, mixed $value): void
    {
        $this->params[$key] = $value;
    }

    /**
     * Get all variables in the view parameters.
     *
     * @return array An associative array of all variables in the view
     */
    public function vars(): array
    {
        return $this->params;
    }

    /**
     * Set multiple variables in the view parameters.
     *
     * @param array $params An associative array of variables to set in the view
     */
    public function setVars(array $params): void
    {
        $this->params = $params;
    }

    protected function getLayoutDir(): string
    {
        return $this->layoutsDir;
    }
}