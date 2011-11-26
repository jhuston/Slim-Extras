<?php
/**
 * Slim - a micro PHP 5 framework
 *
 * @author      Josh Lockhart
 * @link        http://www.slimframework.com
 * @copyright   2011 Josh Lockhart
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * LiquidView
 *
 * The LiquidView is a Custom View class that renders templates using the
 * Liquid template language (http://www.delacap.com/artikel/Liquid-Templates/) and the
 * [php-liquid library](https://github.com/harrydeluxe/php-liquid).
 *
 * There is one field that you, the developer, will need to change:
 * - mustacheDirectory
 *
 * @package Slim
 * @author  Jeffrey Alan Huston
 */
define('LIQUID_INCLUDE_SUFFIX', 'tpl');
define('LIQUID_INCLUDE_PREFIX', '');
class LiquidView extends Slim_View {

    /**
     * @var string The path to the directory containing Mustache.php
     */
    public static $liquidDirectory = null;

    /**
     * @var string The name of the template to be used as a layout
     */    
    public static $liquidLayout ="layout.tpl";

    /**
     * Renders a template using Liquid.class.php.
     *
     * @see View::render()
     * @param string $template The template name specified in Slim::render()
     * @return string
     */
    public function render( $template ) 
    {
        require_once self::$liquidDirectory . '/Liquid.class.php';
        $l = new LiquidTemplate();
        $_html = $l->parse(file_get_contents($this->getTemplatesDirectory() . '/' . ltrim($template, '/')));
        $this->data['content'] = $l->render($this->data);
        return $this->_render_layout();
    }
    
    
//TODO  Check for layout file, return $this->data['content] if no layout present...some more logic needed here
    public function _render_layout()
    {
      $layout = new LiquidTemplate();
      $layout->parse(file_get_contents($this->getTemplatesDirectory() . '/' . ltrim(self::$liquidLayout, '/')));
      return $layout->render($this->data);
    }
}

?>