<?php
namespace Socketlabs\Message;
/**
 * Represents an individual recipient for a message.
 */
class BulkRecipient extends EmailAddress{

    /**
     * A dictionary containing MergeData items unique to the recipient.
     */
    public $mergeData = array();

    /**
     * Add a new merge data oject to the array if the given values are valid.
     * @param string $name
     * @param string $value
     */
    public function addMergeData($name, $value){
        if(!is_string($name)) throw new InvalidArgumentException("The merge field name property must be type string.");
        if(!is_string($value)) throw new InvalidArgumentException("The merge field value property must be type string.");
        $newMergeData = (object)array(
            "Name" => $name,
            "Value" => $value
        );
        foreach($this->mergeData as &$mergeData){
            // case-insensitive matching
            if(strcasecmp($mergeData->Name, $newMergeData->Name) == 0) {
                $mergeData = $newMergeData;
                return;
            }
        }
        $this->mergeData[] = $newMergeData; 

        return $this;
    }
}