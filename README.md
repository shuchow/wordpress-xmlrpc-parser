# wordpress-xmlrpc-parser

This class parses the XML-RPC payload that is passed to WordPress's xmlrpc.php file.  Instantiate the class then call parsePayload() to get the values passed.  If no payload is passed at instantiation, the class uses php://input to read the raw request body.   

    $parser = new Parser();
    $payload = $parser->parsePayload();

See https://github.com/shuchow/wordpress-xmlrpc-shell.git on how this class can be used in xmlrpc.php.

Parameters parsed from the XML-RPC request are:

* methodName - The name of the XML-RPC method being called.
* userName - WordPress user name used for the XML-RPC request.
* password - Password fo the WordPress user.
* dateTime - DateTime object of the call.
* title - Title of th call.
* body - Descscription of the call.
* tags - A post's tags.
* categories - A post's categories.
* postStatus - Status of the post.

This class was developed to ingest IFTTT's WordPress Create Post action.  It has not been thoroughly tested against other XML-RPC calls.
