<?php

/* layout/header/header_settings/profile.twig */
class __TwigTemplate_e1b629779b11a329775fd542d44a1284bff7752b44bdadb1df031fbd8f65f251 extends \XLite\Core\Templating\Twig\Template
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
        // line 6
        echo "
";
        // line 7
        if ($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "isLogged", array(), "method")) {
            // line 8
            echo "\t<li class=\"account-link-profile\">
\t\t<a href=\"";
            // line 9
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url')->getCallable(), array($this->env, $context, "order_list", "")), "html", null, true);
            echo "\" class=\"profile icon-my-account-profile\">
\t\t\t<span>";
            // line 10
            echo XLite\Core\Templating\Twig\Extension\xcart_twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('t')->getCallable(), array("My account")), "html", null, true);
            echo "</span>
\t\t</a>
\t</li>
";
        }
    }

    public function getTemplateName()
    {
        return "layout/header/header_settings/profile.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 10,  27 => 9,  24 => 8,  22 => 7,  19 => 6,);
    }
}
/* {##*/
/*  # Account link*/
/*  #*/
/*  # @ListChild (list="slidebar.additional-menu.links", weight="10")*/
/*  #}*/
/* */
/* {% if this.isLogged() %}*/
/* 	<li class="account-link-profile">*/
/* 		<a href="{{ url('order_list', '') }}" class="profile icon-my-account-profile">*/
/* 			<span>{{ t('My account') }}</span>*/
/* 		</a>*/
/* 	</li>*/
/* {% endif %}*/
/* */
