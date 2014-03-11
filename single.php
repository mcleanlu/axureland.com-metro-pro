<?php

function add_acf()
{
	if(get_field('demo'))
	{
		echo '<a href="' . get_field('demo') . '" target="_blank"><button>Demo</button></a> ';
	}
	if(get_field('download'))
	{
		echo '<a href="' . get_field('download') . '" target="_blank"><button>Download</button></a>';
	}
}

add_action( 'genesis_entry_content', 'add_acf' );

//* Run the Genesis loop
genesis();