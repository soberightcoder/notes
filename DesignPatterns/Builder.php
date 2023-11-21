<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/7/18
 * Time ${Time}
 */
/**
 * 建造者模式；
 * 创建者设计模式，使你能够分步骤创建复杂对象；
 * sql的链式操作；
 */

/**
 * 概念的示例
 */

class Product
{
    public $parts = [];
    // 获取一件产品的步骤
    public function listparts() {
        echo implode($this->parts,"-----");
        echo "\n";
    }
}
// 创建一个产品 需要n个步骤； 不同的创建器  相同的方法 内容也可能是不同的；
interface Builder
{
    public function producePart1();

    public function producePart2();

    public function producepart3();
}


class ConcreteBuilderA implements Builder
{
    private $product;
    public function __construct() {
        $this->reset();
    }
    // 重置
    public function reset() {
        $this->product = new Product();
    }
    // 创建一个产品需要这一下几个步骤；但是不一定全部都用；
    public function producePart2() {
        $this->product->parts[] = 'part2';
    }
    public function producePart1() {
        $this->product->parts[] = 'part1';
    }
    public function producepart3() {
        $this->product->parts[] = 'part3';
    }
    // 获取建造的过程； 产品结束之后创建一个新的产品 parts == []
    public function getPrpduce() {
        $res = $this->product;
        $this->reset();
        return $res;
    }
}
// 指挥者 要定义建造步骤
class Director
{
   private $builder;

    public function setBuilder(Builder $builder) {
        $this->builder = $builder;
   }

    public function buildminvaluehouse() {
        $this->builder->producePart1();
   }

    public function buildmaxvaluehouse() {
        $this->builder->producePart1();
        $this->builder->producePart2();
        $this->builder->producePart3();
   }
}

$director = new Director();
$builder = new ConcreteBuilderA();
$director->setBuilder($builder);
$director->buildmaxvaluehouse();//
$builder->getPrpduce()->listParts();// 查看建造步骤
die;
/**
 * The Builder interface declares a set of methods to assemble an SQL query.
 *
 * All of the construction steps are returning the current builder object to
 * allow chaining: $builder->select(...)->where(...)
 */
interface SQLQueryBuilder
{
    public function select(string $table, array $fields): SQLQueryBuilder;

    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder;

    public function limit(int $start, int $offset): SQLQueryBuilder;

    // +100 other SQL syntax methods...

    public function getSQL(): string;
}

/**
 * Each Concrete Builder corresponds to a specific SQL dialect and may implement
 * the builder steps a little bit differently from the others.
 *
 * This Concrete Builder can build SQL queries compatible with MySQL.
 */
class MysqlQueryBuilder implements SQLQueryBuilder
{
    protected $query;

    protected function reset(): void {
        //  这里是可以存放产品的那个产品；
        $this->query = new \stdClass();// 这里的对象仅仅是起到了一个存储的作用；
    }

    /**
     * Build a base SELECT query.
     */
    public function select(string $table, array $fields): SQLQueryBuilder {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    /**
     * Add a WHERE condition.
     */
    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    /**
     * Add a LIMIT constraint.
     */
    public function limit(int $start, int $offset): SQLQueryBuilder {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    /**
     * Get the final query string.
     */
    public function getSQL(): string {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";
        return $sql;
    }
}

/**
 * This Concrete Builder is compatible with PostgreSQL. While Postgres is very
 * similar to Mysql, it still has several differences. To reuse the common code,
 * we extend it from the MySQL builder, while overriding some of the building
 * steps.
 */
class PostgresQueryBuilder extends MysqlQueryBuilder
{
    /**
     * Among other things, PostgreSQL has slightly different LIMIT syntax.
     */
    public function limit(int $start, int $offset): SQLQueryBuilder {
        parent::limit($start, $offset);

        $this->query->limit = " LIMIT " . $start . " OFFSET " . $offset;

        return $this;
    }

    // + tons of other overrides...
}


/**
 * Note that the client code uses the builder object directly. A designated
 * Director class is not necessary in this case, because the client code needs
 * different queries almost every time, so the sequence of the construction
 * steps cannot be easily reused.
 *
 * Since all our query builders create products of the same type (which is a
 * string), we can interact with all builders using their common interface.
 * Later, if we implement a new Builder class, we will be able to pass its
 * instance to the existing client code without breaking it thanks to the
 * SQLQueryBuilder interface.
 */
function clientCode(SQLQueryBuilder $queryBuilder) {
    // ...

    $query = $queryBuilder
        ->select("users", ["name", "email", "password"])
        ->where("age", 18, ">")
        ->where("age", 30, "<")
        ->limit(10, 20)
        ->getSQL();

    echo $query;

    // ...
}


/**
 * The application selects the proper query builder type depending on a current
 * configuration or the environment settings.
 */
// if ($_ENV['database_type'] == 'postgres') {
//     $builder = new PostgresQueryBuilder(); } else {
//     $builder = new MysqlQueryBuilder(); }
//
// clientCode($builder);


echo "Testing MySQL query builder:\n";
clientCode(new MysqlQueryBuilder());