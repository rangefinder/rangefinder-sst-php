<?php
namespace Rangefinder;
class Track1 {
  public static $clientKey;
  public static $clientSite;
  
  public static $endpoint = 'rangefinderapp.com';
  public static $port     = 8001;
  public static $script   = 'rangefinderapp.com/track1.js';
  
  private static $id = 0;
  private static $sock = null;
  
  private static function connect() {
    self::$sock = fsockopen('udp://'.self::$endpoint, self::$port);
  }
  private static function disconnect() {
    fclose(self::$sock);
    self::$sock = null;
  }
  
  public static function track() {
    // Try to connect the socket.
    if(!self::$sock) self::connect();
    if(self::$sock) {
      // Getting all the variables:
      $page = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // Must assume HTTP right now.
      $referrer = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
      $user_agent = (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
      $ipv4 = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
      $time = time();
      $id = rand(0, 1000000);
      // Build and send the packet:
      $packet = 'track:'.http_build_query(array(
        'key' => self::$clientKey,
        'page' => $page,
        'referrer' => $referrer,
        'user_agent' => $user_agent,
        'ipv4' => $ipv4,
        'time' => $time,
        'id' => $id
      ))."\n";
      if(strlen($packet) < 1499) {
        fwrite(self::$sock, $packet);
        self::disconnect();
      } else {
        $id = -2;// Too long
      }
    } else {
      $id = -1;// No socket
    }
    self::$id = $id;
    return $id;
  }
  public static function code() {
    ?>
    <script type="text/javascript">
      var _rangefinder_queue = _rangefinder_queue || [];
      _rangefinder_queue.push(['track', <?php echo self::$clientSite; ?>, <?php echo self::$id; ?>]);
      document.write(unescape("%3Cscript src='//<?php echo self::$script; ?>' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <?php
  }
}
