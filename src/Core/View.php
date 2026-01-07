<?php
namespace App\Core;

class View implements Contract\ViewInterface
{
    const DEFAULT_TEMPLATE = 'index';
    const TEMPLATES_DIR = __DIR__ . '/../../views/';
    protected string $layoutsDir = __DIR__ . '/../../views/layout/';
    protected string $pageLayout = 'page.phtml';
    
    private string $template = self::DEFAULT_TEMPLATE;
    private array $children = [];
    private array $params = [];

    public function __construct(
        private Request $request, 
        ?string $template = null, 
        array $params = []
    ) {
        $this->template = $template ?? self::DEFAULT_TEMPLATE;
        $this->params = $params;
    }

    
    public function __invoke(string $var, mixed $value = null): mixed
    {
        if ($value === null) {
            return $this->params[$var] ?? null;
        }

        $this->params[$var] = $value;
        return $this;
    }

    public function getTemplate(): string
    {
        return self::TEMPLATES_DIR . $this->template . '.phtml';
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function render(array $params = [], bool $standalone = false): string
    {
        ob_start();
        try{
            $this->params = array_merge($this->params, $params);

            if ($standalone) { // If rendering standalone, include only the view file. f.e. ajax requests
                $viewFile = self::TEMPLATES_DIR . $this->template . '.phtml';
                    if (!file_exists($viewFile)) {
                    throw new \RuntimeException("View not found: $viewFile");
                }
                include $viewFile;
                return ob_get_clean();
            }
            
            $layoutDir = $this->getLayoutDir();
            include $layoutDir . $this->pageLayout;
            return ob_get_clean();
        } catch (\Throwable $e) {
            
            throw $e;
        }

        //$content = ob_end_clean();

        //echo $content;
    }

    /**
     *
     * @return Request The request object
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    protected function getLayoutDir(): string
    {
        return $this->layoutsDir;
    }
}