<?php

/* layout/header/header_settings/logout.twig */
class __TwigTemplate_e5bbff8aae0e1563d9df86ba7986172ccf3069284a499a368a60444b9c266fb4 extends \XLite\Core\Templating\Twig\Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 7
        echo "
";
        // line 8
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isLogged", array(), "method")) {
            // line 9
            echo "\t<ul class='quick-links'>
\t\t<li class=\"account-link-logoff\">
\t\t\t<a href=\"";
            // line 11
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array($this->env, $context, "login", "logoff")), "html", null, true);
            echo "\" class=\"log-off icon-logout\">
\t\t\t\t<span>";
            // line 12
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("Log out")), "html", null, true);
            echo "</span>
\t\t\t</a>
\t\t</li>
\t</ul>
";
        }
    }

    public function getTemplateName()
    {
        return "layout/header/header_settings/logout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  32 => 12,  28 => 11,  24 => 9,  22 => 8,  19 => 7,);
    }
}
/* {##*/
/*  # Log out link*/
/*  #*/
/*  # @ListChild (list="slidebar.additional-menu", weight="1000")*/
/*  # @ListChild (list="layout.header.right.settings", weight="1000")*/
/*  #}*/
/* */
/* {% if this.isLogged() %}*/
/* 	<ul class='quick-links'>*/
/* 		<li class="account-link-logoff">*/
/* 			<a href="{{ url('login', 'logoff') }}" class="log-off icon-logout">*/
/* 				<span>{{ t('Log out') }}</span>*/
/* 			</a>*/
/* 		</li>*/
/* 	</ul>*/
/* {% endif %}*/
/* */
