<?php
	class QueueManager {
		protected $twilio = null;
		protected $queue  = null;
		
		public function __construct($accountsid, $authtoken, $callqueue_sid='') {
			$this->twilio = new Services_Twilio($accountsid, $authtoken); 
			if( isset( $callqueue_sid ) && !empty( $callqueue_sid ) ){
				$this->queue = $this->twilio->account->queues->get( $callqueue_sid );
			}else{
				$this->loadFirstQueue();
			}
		}
		
		public function loadFirstQueue() {
			//API call
			$queues = $this->twilio->account->queues;
			foreach($queues as $queue) {
				$this->queue = $queues;
				break;
			}
		}
		
		public function getMembers() {
			return $this->queue->members;
		}
		
		public function getCurrentWaitTime() {
			return $this->queue->average_wait_time;
		}
		
		public function getCurrentOnHoldCount() {
			return $this->queue->current_size;
		}
		
		public function connectNextCaller($destinationUrl) {
			$first = $this->queue->members->front();
			
			//API call
			$first->dequeue($destinationUrl, 'POST');
		}
	}