<?php
namespace SmartpaySDK;

class engine{

    public function smartCurl($data = array()){

			global $gclient;
			$this->gclient = $gclient;
			try{
				$response = $this->gclient->request(
					'POST',
					API_URL,
					[
						// 'debug' => true,
						'verify' => false,					
						'form_params' => $data
					]
				);
			} catch (\Exception $e) {					
				error_log($e->getMessage(), 0);
			}

			$response_code = $response->getStatusCode();
			
            $response_level = substr($response_code, 0, 1);
            if($response_level == '2'){
				$response = json_decode($response->getBody(), true);   
				// $response = $response->getBody(); 
				// die($response);  
				return $response;             
            }
            else{
				// echo $response->getReasonPhrase();
                return false;
            }
			return json_decode($response->getBody());
			// return $response->getBody();
			
		}

}