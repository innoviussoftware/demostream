 <?php if ($this->get('show_thumbnail') === true) { 
		
 } 
		  $this->get('video_title'); 
	
 if ($this->get('no_stream_map_found', false) === true) { 
		  $this->get('no_stream_map_found_dump'); 	
 }
else
{ 
 if ($this->get('show_debug1', false) === true) { 
		  $this->get('debug1'); 
	
 } 
	
 foreach($this->get('streams', []) as $format) { 
		
 if ($format['show_direct_url'] === true && $format['type'] == 'video/mp4') {
	
 echo $format['direct_url'];
exit; }
}
}
?>