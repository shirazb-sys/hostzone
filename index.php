<html>
<head>
    <title>Metadata</title>
</head>
<body>

<?php
    // For IMDSv2, first you need to get the token
    $ch = curl_init();

    $headers = array ('X-aws-ec2-metadata-token-ttl-seconds: 21600' );
    $url = "http://169.254.169.254/latest/api/token";

    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
    curl_setopt( $ch, CURLOPT_URL, $url );
    $token = curl_exec( $ch );

    // echo "<pre> TOKEN : " . $token . "</pre>";
    
    // Once you have token, get instance metadata
    $url = "http://169.254.169.254/latest/dynamic/instance-identity/document";
    $headers = array ('X-aws-ec2-metadata-token: ' . $token );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
    $result = curl_exec($ch);
    $instance = json_decode($result);
    
    curl_setopt( $ch, CURLOPT_URL, "http://169.254.169.254/latest/meta-data/public-ipv4");
    //curl_setopt( $ch, CURLOPT_URL, "https://icanhazip.com");
    $ipv4 = curl_exec($ch);

    curl_close($ch);
?>
<div class="center">
<table>
    <tbody>
    <tr>
    <th>Availability Zone</th>
    <td><?= $instance->availabilityZone ?></td>

    <th>Instance Id</th>
    <td><?= $instance->instanceId ?></td>

    <th>Private IP</th>
    <td><?= $instance->privateIp ?></td>
    </tr>
    <tr>
    <th>Instance Type</th>
    <td><?= $instance->instanceType ?></td>
    <th>AMI ID</th>
    <td><?= $instance->imageId ?></td>
    <th>Public IP</th>
    <td><?= $ipv4 ?></td>
    </tr>
    </tbody>
</table></div>
<?php
    phpinfo();
?>    
</body>
</html>
