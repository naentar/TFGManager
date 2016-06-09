<?php
// file: view/layouts/language_select_element.php
?>
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= i18n("Escoger idioma")?><span class="caret"></span></a>
	<ul class="dropdown-menu menuOc" role="menu">
		<li class="menuItem"><a href="index.php?controller=language&amp;action=change&amp;lang=es"><?= i18n("Espa&ntilde;ol")?></a></li>
		<li class="menuItem"><a href="index.php?controller=language&amp;action=change&amp;lang=en"><?= i18n("Ingl&eacute;s")?></a></li>
		<li class="menuItem"><a href="index.php?controller=language&amp;action=change&amp;lang=ga"><?= i18n("Gallego")?></a></li>
	</ul>
</li>