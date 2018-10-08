<?php
namespace Socketlabs\Message;
/**
 * A bulk message usually contains a single recipient per message 
 * and is generally used to send the same content to many recipients, 
 * optionally customizing the message via the use of MergeData.
 */
class BulkMessage extends  BaseMessage{
    
    /**
     * An array of the message recipients
     */
    public $to = array();

    /**
    * A array containing MergeData items that will be global across the whole message.
     */
    public $global = array();

    /**
     * Add recipients to this message
     * @param string $emailAddress
     * @param string $friendlyName
     */
    public function addToAddress($emailAddress, $friendlyName = null){
        if(is_string($emailAddress)){  
            return $this->addToAddress(new BulkRecipient($emailAddress, $friendlyName)); 
        }
        else if(is_a($emailAddress, "Socketlabs\Message\BulkRecipient")){
            $this->to[] = $emailAddress;
            return $emailAddress;
        }
        else{
            throw new \BadFunctionCallException("BulkMessage::addToAddress() parameter must be type string or type BulkRecipient.");
        }
    }

    /**
     * Add global merge data to the message
     * @param string $name
     * @param string $value
     */
    public function addGlobalMergeData($name, $value){
        if(!is_string($name)) throw new \InvalidArgumentException("The global merge data name property must be type string.");
        if(!is_string($value)) throw new \InvalidArgumentException("The global merge data value property must be type string.");
        $newMergeData = (object)array(
            "Name" => $name,
            "Value" => $value
        );
        foreach($this->global as &$mergeData){
            // case-insensitive matching
            if(strcasecmp($mergeData->Name, $newMergeData->Name) == 0) {
                $mergeData = $newMergeData;
                return $this;
            }
        }
        $this->global[] = $newMergeData; 
        return $this;
    }

}