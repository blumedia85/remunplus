<?php  namespace Mentordeveloper\Library\Traits;
/**
 * Trait OverrideConnectionTrait
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
use App;

trait OverrideConnectionTrait {
    /**
     * @override
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        return (App::environment() != 'testing') ? static::resolveConnection('authentication'): static::resolveConnection($this->connection);
    }
} 