<?php
use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;

function getSecret( $secretKey ) {
  $serverConfig = get_server_config();

  $client = new SecretsManagerClient([
    'version' => '2017-10-17',
    'region' => 'us-east-1',
  ]);

  if ($serverConfig['env_name'] === 'production') {
    $secretName = "coschedule-headline-analyzer-production";
  } else {
    $secretName = "coschedule-headline-analyzer-staging";
  };

  try {
    $result = $client->getSecretValue([
        'SecretId' => $secretName,
    ]);
  } catch (AwsException $e) {
    $error = $e->getAwsErrorCode();
    if ($error == 'DecryptionFailureException') {
      // Secrets Manager can't decrypt the protected secret text using the provided AWS KMS key.
      // Handle the exception here, and/or rethrow as needed.
      throw $e;
    }
    if ($error == 'InternalServiceErrorException') {
      // An error occurred on the server side.
      // Handle the exception here, and/or rethrow as needed.
      throw $e;
    }
    if ($error == 'InvalidParameterException') {
      // You provided an invalid value for a parameter.
      // Handle the exception here, and/or rethrow as needed.
      throw $e;
    }
    if ($error == 'InvalidRequestException') {
      // You provided a parameter value that is not valid for the current state of the resource.
      // Handle the exception here, and/or rethrow as needed.
      throw $e;
    }
    if ($error == 'ResourceNotFoundException') {
      // We can't find the resource that you asked for.
      // Handle the exception here, and/or rethrow as needed.
      throw $e;
    }
  }

  if (isset($result['SecretString'])) {
    $secret = $result['SecretString'];
  } else {
    $secret = base64_decode($result['SecretBinary']);
  }
  return json_decode( $secret ) -> $secretKey;
}
?>