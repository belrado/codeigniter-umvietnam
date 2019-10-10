<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('html_purify'))
{
    function html_purify($dirty_html, $type = FALSE)
    {
        //require_once './assets/lib/htmlpurifier/library/HTMLPurifier.auto.php';
        require_once './assets/lib/htmlpurifier4_10/library/HTMLPurifier.auto.php';
        if (is_array($dirty_html))
        {
            foreach ($dirty_html as $key => $val)
            {
                $clean_html[$key] = html_purify($val, $config);
            }
        }
        else
        {
            $ci =& get_instance();
			$config = HTMLPurifier_Config::createDefault();
            switch ($type)
            {
                case 'comment':
                    $config = HTMLPurifier_Config::createDefault();
                    $config->set('Core.Encoding', $ci->config->item('charset'));
                    $config->set('HTML.Doctype', 'XHTML 1.0 Strict');
					$config->set('AutoFormat.AutoParagraph', TRUE);
					$config->set('AutoFormat.Linkify', TRUE);
					$config->set('AutoFormat.RemoveEmpty', TRUE);
					$config->set('HTML.Allowed', 'span[style],div[style],dl[style],dt[style],dd[style],p[style],ul[style],ol[style],li[style],table[style|border|cellspacing],tr,td[style],th[style],img[style|src|alt],blockquote[cite],h1[style],h2[style],h3[style],h4[style],h5[style],strong,u,em,code,i,strike,a[href|title|target]');
					//$config->set('HTML.AllowedAttributes', 'href, src, alt, style');
					$config->set('HTML.TargetBlank', true);
					$config->set('CSS.AllowedProperties', 'text-align, font-size, font-style, font-family, line-height');
					//$config->set('Attr.EnableId', true);
					//$config->set('Attr.EnableClass', true);
					//$config->set('Attr.DefaultImageAlt', '');
                    break;
				case 'admin_html' :
				 $config = HTMLPurifier_Config::createDefault();
					$config = HTMLPurifier_Config::createDefault();
                    $config->set('Core.Encoding', $ci->config->item('charset'));
                    $config->set('HTML.Doctype', 'XHTML 1.0 Strict');
					$config->set('AutoFormat.AutoParagraph', TRUE);
					$config->set('AutoFormat.Linkify', TRUE);
					$config->set('AutoFormat.RemoveEmpty', TRUE);
					$config->set('HTML.TargetBlank', true);
					$config->set('CSS.AllowedProperties', 'background, background-color, color, text-align, font-size, font-style, font-family, line-height, width, border');
					//$config->set('Attr.EnableClass', true);
					break;
                case FALSE:
                    $config = HTMLPurifier_Config::createDefault();
                    $config->set('Core.Encoding', $ci->config->item('charset'));
                    $config->set('HTML.Doctype', 'XHTML 1.0 Strict');
                    break;
                default:
                    show_error('The HTMLPurifier configuration labeled "' . htmlentities($config, ENT_QUOTES, 'UTF-8') . '" could not be found.');
            }

            $purifier = new HTMLPurifier($config);
            $clean_html = $purifier->purify($dirty_html);
        }
        return $clean_html;
    }
}
