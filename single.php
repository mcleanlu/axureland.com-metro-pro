<?php

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
	
	echo '</div>' . $data;
}

add_action( 'genesis_entry_content', 'add_acf' );

//* Run the Genesis loop
genesis();