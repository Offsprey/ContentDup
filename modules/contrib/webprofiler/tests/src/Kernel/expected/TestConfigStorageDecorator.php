<?php

namespace Drupal\webprofiler_config_entity;

use Drupal\webprofiler\Entity\ConfigEntityStorageDecorator;
use Drupal\Core\Config\Entity\ConfigEntityStorage;
use Drupal\node\Entity\Node;

/**
 * This file is auto-generated by the Webprofiler module.
 */
class TestConfigStorageDecorator extends ConfigEntityStorageDecorator implements \Drupal\webprofiler_config_entity\TestConfigStorageInterface
{
    public function method0()
    {
        return $this->getOriginalObject()->method0();
    }
    public function method1(): void
    {
        $this->getOriginalObject()->method1();
    }
    public function method2($param1): int
    {
        return $this->getOriginalObject()->method2($param1);
    }
    public function method3(string $param1): string
    {
        return $this->getOriginalObject()->method3($param1);
    }
    public function method4(string $param1, string $param2): string|null
    {
        return $this->getOriginalObject()->method4($param1, $param2);
    }
    public function method5(?string $param1 = NULL): ?string
    {
        return $this->getOriginalObject()->method5($param1);
    }
    public function method6(bool $param1 = FALSE): mixed
    {
        return $this->getOriginalObject()->method6($param1);
    }
    public function method7(bool $param1 = TRUE): void
    {
        $this->getOriginalObject()->method7($param1);
    }
    public function method8(array $param1 = []): void
    {
        $this->getOriginalObject()->method8($param1);
    }
    public function method9(int $param1 = 5): void
    {
        $this->getOriginalObject()->method9($param1);
    }
    public function method10(string $param1): void
    {
        $this->getOriginalObject()->method10($param1);
    }
    public function method11(?array $param1 = NULL): array
    {
        return $this->getOriginalObject()->method11($param1);
    }
    public function method12(string ...$param1): float
    {
        return $this->getOriginalObject()->method12($param1);
    }
    public function method13(string &$param1): bool
    {
        return $this->getOriginalObject()->method13($param1);
    }
    public function method14(Node $param1): bool
    {
        return $this->getOriginalObject()->method14($param1);
    }
    public function method15(Node $param1): Node
    {
        return $this->getOriginalObject()->method15($param1);
    }
}
