<?php
/*
	Section: HTMLBlock
	Author: opportunex
	Author URI: http://www.opportunex.com/paglines/htmlblock
	Description: A simple HTML block and options for extending standard content.
	Class Name: PageLinesHTMLBlock
	Workswith: templates, main, header, morefoot, sidebar1, sidebar2, sidebar_wrap
	Version: 1.0.0
	Edition: pro
	Cloning: true
*/

class PageLinesHTMLBlock extends PageLinesSection {

	function section_optionator( $settings ){
		
		$settings = wp_parse_args($settings, $this->optionator_default);
		
		$metatab_array = array(

				'html_block_class' => array(
					'type' 			=> 'text',	
					'title' 		=> 'HTML Block Class',
					'shortexp' 		=> 'Applies this class to the HTML content block for individual styling'
				),
				'html_block_content' => array(
					'type' 			=> 'textarea',
					'inputsize'		=> 'big',		
					'title' 		=> 'HTML Block Content',
					'shortexp' 		=> 'Add HTML content for this block'
				),
                'html_block_scripts' => array(
					'type' 			=> 'textarea',
					'inputsize'		=> 'big',		
					'title' 		=> 'Custom HTML Scripts',
					'shortexp' 		=> 'Add add custom JavaScript or JQuery. This option is for advaced users only.  Make sure you know what you are doing or you can break your site! Scripts and styles are displayed "inline".  <em>(<script></script> tag already included.)</em>'
				),
                'html_block_styles' => array(
					'type' 			=> 'textarea',
					'inputsize'		=> 'big',		
					'title' 		=> 'Custom HTML Style',
					'shortexp' 		=> 'Add add custom CSS for HTML block.  Make sure you know what you are doing or you can break your site! Scripts and styles are displayed "inline". <em>(<style></style> tag already included.)</em>'
				),
			);
		
		$metatab_settings = array(
				'id' 		=> $this->id.'meta',
				'name' 		=> $this->name,
				'icon' 		=> $this->icon, 
				'clone_id'	=> $settings['clone_id'], 
				'active'	=> $settings['active']
			);
		
		register_metatab($metatab_settings, $metatab_array);
	}

	function section_template( $clone_id ) { 

		$class = (ploption('html_block_class', $this->oset)) ? ploption('html_block_class', $this->oset) : 'html-standard';
		$content = ploption('html_block_content', $this->oset);
		$scripts = ploption('html_block_scripts', $this->oset);
        $css = ploption('html_block_styles', $this->oset);
            
		if($content){
            
            $c = do_shortcode( $content );
            
            printf('<div class="hentry %s"><div class="hentry-pad %s-pad entry_content">%s</div></div>', $class, $class, $c, $scripts, $css);
            printf('<script type="text/javascript">'.$scripts.'</script>');
            printf('<style>'.$css.'</style>');

		} else
			echo setup_section_notify($this, __('Add content to meta option to activate.', 'pagelines') );
 
	}

} /* End of section class */