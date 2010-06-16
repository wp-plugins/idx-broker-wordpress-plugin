<?php

/**
 *	CLASS wrapper - holds all the functions that grab, manipulate and save/return the wrapper for the IDX Broker system
 */

class wrapper {
	
	private $wrapper; 	// the full page code
	private $header;	// the header code
	private $footer;	// the footer code
	
	private $headerFile = "../wp-content/plugins/idx-broker-wordpress-plugin/wrapper/header.php";
	private $footerFile = "../wp-content/plugins/idx-broker-wordpress-plugin/wrapper/footer.php";
	
	public function setWrapper($wrapper){
		
		$this->wrapper = $wrapper;
		
	}
	
	public function getWrapper(){
		
		return $this->wrapper;
		
	}
	
	public function setHeader($header){
		
		$this->header = $wrapper;
		
	}
	
	public function getHeader(){
		
		return $this->header;
		
	}
	
	public function setFooter($footer){
		
		$this->footer = $wrapper;
		
	}
	
	public function getFooter(){
		
		return $this->footer;
		
	}
	
	public function getHeaderPath(){
		
		return $this->headerFile;
		
	}
	
	public function getFooterPath(){
		
		return $this->footerFile;
		
	}
	
	public function getPermissions() {
		
		if((substr(sprintf('%o', fileperms($this->headerFile)), -4)) == "0666" && (substr(sprintf('%o', fileperms($this->footerFile)), -4))){
			return true;
		} else {
			return false;
		}
		
	}
	
	/**
	 * Get the wrapper code by cURLing it
	 * @param string $url - The address to get the code from
	 * @return string $wrapper - The full page code
	 */

	public function getPage() {
		
		/*
		*	cUrl the index page of the plog to get the raw html code
		*/
		
		$url = get_bloginfo('url').'/';
		
		$curl_handle = curl_init();
		curl_setopt( $curl_handle, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
		curl_setopt( $curl_handle, CURLOPT_URL, $url );
		curl_setopt( $curl_handle, CURLOPT_ENCODING, "" );
		curl_setopt( $curl_handle, CURLOPT_AUTOREFERER, true );
		curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl_handle, CURLOPT_MAXREDIRS, 10 );
		$pageCode = curl_exec($curl_handle);
		curl_close($curl_handle);
		
		/*
		*	Check to see if the start flag is present, if so move on
		*/
	
		if( stristr($pageCode, idx_start() )) {
			
			/*
			*	Check to see if the stop flag is present, if so return true
			*/
			
			if(stristr($pageCode, idx_stop() )) {
				
				$this->wrapper = $pageCode;
			
			/*
			*	Stop flag is not present, return false
			*/
			
			} else {
				
				return false;
			
			} // end if idx_stop()
			
		/*
		*	Start flag is not present, return false
		*/
			
		} else {
			
			return false;
		
		} // end if idx_start()
		
	} // end getWrapper()
	
	/**
	 * Take the inputed full page code and parse out the header and footer.
	 * @param string $wrapper - The full page code to parse
	 * @param string $section - The part of the page to return (header/footer)
	 * @return string - Either the header code or the footer code
	 */
	
	public function parseWrapper() {
			
		/*
		*	To parse out the string we have to get around earlier versions of php. First we reverse the
		*	string and look for our reversed start flag.  Then we need to reverse the string back to normal
		*	and cut out the actual flag from the code. Return the header.
		*	
		*/
		
		$this->header = substr(strrev(stristr(strrev($this->wrapper), '>vid/<>";enon :yalpsid"=elyts "tratSxdi"=di vid<')), 0, -48); // 48 char
				
		/*
		*	This is the same process as returning the header, except we dont need to reverse the string, as
		*	our flag will be at the beginning of the code block. Return the footer.
		*/
		
		$this->footer = substr(stristr($this->wrapper, '<div id="idxStop" style="display: none;"></div>'), 47); //47 char
		
	} // end parseWrapper()
	
	/**
	 * Check to see if we wrote anything to the header and footer files in the wrapper folder
	 * @return boolean - Either we succeeded or we failed
	 */
	
	private function adminCheckWrapper() {

		/*
		*	If the file size of the header file is greater than 0.
		*/
		
		if(filesize($this->headerFile) > 0){
			
			/*
			*	If the file size of the footer file is greater than 0.
			*/
			
			if(filesize($this->footerFile) > 0){
				
				/*
				*	Both the header and the footer have a filesize that
				*	is greater than 0, die and return TRUE.
				*/
				
				die('1');
				
			} else {
				
				die('0');
				
			} // end filesize of footer
			
		} else {
			
			die('0');
			
		} // end if filesize of header
		
	} // end adminCheckWrapper()
	
	/*
	*	Check to see if the start flag is present, if so move on
	*/
	
	public function checkTags(){
		
		$this->getPage();

		if( stristr($this->wrapper, idx_start() )) {
			
			/*
			*	Check to see if the stop flag is present, if so return true
			*/
			
			if(stristr($this->wrapper, idx_stop() )) {
				
				return true;
			
			/*
			*	Stop flag is not present, return false
			*/
			
			} else {
				
				return false;
			
			} // end if idx_stop()
			
		/*
		*	Start flag is not present, return false
		*/
			
		} else {
			
			return false;
		
		} // end if idx_start()
	
	}
	
} // end class wrapper


?>