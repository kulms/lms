<?
	header("Pragma: ");
	header("Cache-Control: ");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");  //HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	// END extra headers to resolve IE caching bug

	header( "Content-length: {$file['file_size']}" );
	header( "Content-type: {$file['file_type']}" );
	header( "Content-disposition: attachment; filename={$file['file_name']}" );
	readfile( "{$AppUI->cfg['root_dir']}/files/{$file['file_project']}/{$file['file_real_filename']}" );
?>