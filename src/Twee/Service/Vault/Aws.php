<?php
namespace Twee\Service\Vault;

use Aws\Ssm\SsmClient as AwsSsmClient;
use DomainException;
use OutOfRangeException;
use InvalidArgumentException;

class Aws implements VaultInterface
{
    private $client = null;
    private $namespace = '';

    public function __construct(array $credentials)
    {
        if (empty($credentials)) {
            throw new DomainException('Empty credentials e.g. '
                . '[credentials => [ ' . PHP_EOL
                . '  key    => ...,' .  PHP_EOL
                . '  secret => ...,' . PHP_EOL
                . '],' . PHP_EOL
                . 'region  => us-east-1,' . PHP_EOL
                . 'version => latest,' . PHP_EOL
                . 'namespace => /twee/,' . PHP_EOL
                . ']');
        }
        if (!array_key_exists('namespace', $credentials)) {
            throw new DomainException('Namespace missed');
        }
        $this->client = new AwsSsmClient($credentials);
        $this->namespace = $credentials['namespace'];
    }

    public function get(string $key) : array
    {
        $key = preg_replace('~[^a-zA-Z0-9/_-]+~', '__', $key);

        $result = $this->client->getParameter([
            'Name' => $this->namespace . $key,
        ]);

        $value = $result->get('Parameter')['Value'];
        if (empty($value)) {
            throw new InvalidArgumentException('Key "' . $key . '" does not exist');
        }
        $decoded = json_decode($value, true);
        if (empty($decoded)) {
            throw new OutOfRangeException('Vault has incorrect format. Expected JSON');
        }

        return $decoded;
    }
}
