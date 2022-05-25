<?php
namespace Socketlabs\Message;
/**
 * Represents a message attachment
 */
class Attachment
{
    /**
     * Name of attachment (displayed in email clients).
     * @var string|null
     */
    public $name = null;

    /**
     * The MIME type for your attachment.
     * @var string|null
     */
    public $mimeType = null;

    /**
     * When set, used to embed an image within the body of an email message.
     * Example - <img> src="cid:contentId" </img>
     * @var string|null
     */
    public $contentId = null;

    /**
     * Raw image data
     * @var string|null
     */
    public $content = null;

    /**
     * An optional list of custom headers added to the attachment
     */
    public $customHeaders = array();

    /**
     * Creates attachment using content from specified path.
     *
     * @param string $path he path to your attachment on your local system.
     * @param string $name Name of attachment (displayed in email clients).
     * @param string $type The MIME type for your attachment.
     * @param string $contentId When set, used to embed an image within the body of an email message.
     * @param string $headers A list of custom headers added to the attachment.
     * @return Attachment
     */
    public static function createFromPath($path, $name = '', $type = '', $contentId = null, $headers = null){

        // If a MIME type is not specified, try to work it out from the file name
        $type = $type == '' ? Attachment::filenameToType($path) : $type;
        $filename = basename($path);
        $name = $name == "" ? $filename : $name;

        $fileResource = fopen($path, 'r');
        try{
            return Attachment::createFromStream($fileResource, $name, $type, $contentId, $headers);
        }
        finally{
            fclose($fileResource);
        }
    }

    /**
     * Creates attachment using content from resource stream.
     *
     * @param resource $resource .
     * @param string $name Name of attachment (displayed in email clients).
     * @param string $type The MIME type for your attachment.
     * @param string $contentId When set, used to embed an image within the body of an email message.
     * @param string $headers A list of custom headers added to the attachment.
     * @return Attachment
     */
    public static function createFromStream($resource, $name = '', $type = '', $contentId = null, $headers = null){

        $attachment = new Attachment();
        $attachment->name = $name;
        $attachment->mimeType = $type;
        $attachment->contentId = $contentId;
        $attachment->customHeaders = $headers;
        $attachment->content = stream_get_contents($resource);

        return $attachment;
    }


    /**
     * Map a file name to a MIME type.
     * Defaults to 'application/octet-stream', i.e.. arbitrary binary data.
     * @since      1.0.0
     * @param string $filename A file name or full path, does not need to exist as a file
     * @return string
     * @static
     */
    public static function filenameToType($filename)
    {
        // In case the path is a URL, strip any query string before getting extension
        $qpos = strpos($filename, '?');
        if (false !== $qpos) {
            $filename = substr($filename, 0, $qpos);
        }
        $pathinfo = self::mb_pathinfo($filename);
        return self::_mime_types($pathinfo['extension']);
    }

    /**
     * Multi-byte-safe pathinfo replacement.
     * Drop-in replacement for pathinfo(), but multibyte-safe, cross-platform-safe, old-version-safe.
     * Works similarly to the one in PHP >= 5.2.0
     * @link http://www.php.net/manual/en/function.pathinfo.php#107461
     * @param string $path A filename or path, does not need to exist as a file
     * @param integer|string $options Either a PATHINFO_* constant,
     *      or a string name to return only the specified piece, allows 'filename' to work on PHP < 5.2
     * @return string|array
     */
    public static function mb_pathinfo($path, $options = null)
    {
        $ret = array('dirname' => '', 'basename' => '', 'extension' => '', 'filename' => '');
        $pathinfo = array();
        if (preg_match('%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', $path, $pathinfo)) {
            if (array_key_exists(1, $pathinfo)) {
                $ret['dirname'] = $pathinfo[1];
            }
            if (array_key_exists(2, $pathinfo)) {
                $ret['basename'] = $pathinfo[2];
            }
            if (array_key_exists(5, $pathinfo)) {
                $ret['extension'] = $pathinfo[5];
            }
            if (array_key_exists(3, $pathinfo)) {
                $ret['filename'] = $pathinfo[3];
            }
        }
        switch ($options) {
            case PATHINFO_DIRNAME:
            case 'dirname':
                return $ret['dirname'];
            case PATHINFO_BASENAME:
            case 'basename':
                return $ret['basename'];
            case PATHINFO_EXTENSION:
            case 'extension':
                return $ret['extension'];
            case PATHINFO_FILENAME:
            case 'filename':
                return $ret['filename'];
            default:
                return $ret;
        }
    }

    /**
     * Gets the mime type from a file extension
     * @param string $ext File extension (w/out dot)
     * @return string MIME type of file.
     */
    public static function _mime_types($ext = '')
    {
        $mimes = array(

            'xml' => "application/xml",

            'txt' => "text/plain",
            'ini' => "text/plain",
            'sln' => "text/plain",
            'cs' => "text/plain",
            'js' => "text/plain",
            'config' => "text/plain",
            'vb' => "text/plain",

            'html' => "text/html",

            'wav' => "audio/wav",

            'eml' => "message/rfc822",

            'mp3' => "audio/mpeg",

            'mp4' => "video/mp4",

            'bmp' => "image/bmp",

            'gif' => "image/gif",

            'jpeg' => "image/jpeg",
            'jpg' => "image/jpeg",

            'png' => "image/png",

            'zip' => "pplication/x-zip-compressed",

            'doc'    => 'application/msword',
            'docx'    => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

            'xls'    => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

            'ppt'    => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',

            'csv'    => 'text/csv',

            'pdf' => 'application/pdf',

            'mov'    => 'video/quicktime'
        );
        if (array_key_exists(strtolower($ext), $mimes)) {
            return $mimes[strtolower($ext)];
        }
        return 'application/octet-stream';
    }


}

