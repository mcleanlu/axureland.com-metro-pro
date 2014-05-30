<?php

/* Demo & Download Buttons*/
function add_acf()
{

	$data = '<div class="demo-download">';
	
	if(get_field('demo'))
	{
		$data .= '<a href="' . get_field('demo') . '" target="_blank"><button>Demo</button></a> ';
	}
	if(get_field('download'))
	{
		$data .= '<a href="' . get_field('download') . '" target="_blank"><button>Download</button></a>';
	}
	
	if(get_field('website'))
	{
		$data .= '<a href="http://' . get_field('website') . '" target="_blank"><button>Website</button></a>';
	}
	
	echo '</div>' . $data;
}

add_action( 'genesis_entry_content', 'add_acf' );

add_action( 'genesis_entry_footer', 'show_share_buttons' );
function show_share_buttons(){
     
  if ( function_exists( 'sharing_display' ) ) {
 echo sharing_display();
 
  }
     
}

//* Run the Genesis loop
genesis();