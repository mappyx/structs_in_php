<?php
/**
 * @author Rafael Jose Paez Villanueva
 * @email jugamus@gmail.com
 * @github /varcangel
 * @version 1.0
 * @description This is a model of a data structure known as a Queue
 * @php 7.1
 */

 /**
  * @property protected string $data
  * @property protected Node &$next
  * @property protected Node &$previus
  * @method public getData(): string
  * @method public getCurrent(): Node
  * @method public setNext(Node &$node): void
  * @method public setPrevius(Node &$node): void
  * @method public deleteNext(): void
  * @method public deletePrevius(): void
  * @method public setData($element): void
  * @method public new($data = ''): Node
  * @method public delete(): Node
  * @method public next(): Node
  * @method public previus(): Node
  * @method public search($element): string
  */
class Node
{
    /**
     * @var string
     */
    protected $data = '';
    /**
     * @var Node
     */
    protected $next = null;
    /**
     * @var Node
     */
    protected $previus = null;

    /**
     * @param string $data
     */
    public function __construct($data = '')
    {
        $this->setData($data);
    }

    public function __destruct()
    {
        unset($this->data, $this->next, $this->previus);    
    }

    /**
     * @return Node|null
     */
    public function next()
    {
        return $this->next ?? null;
    }

    /**
     * @return Node|null
     */
    public function previus()
    {
        return $this->previus ?? null;
    }

    /**
     * @param string $element
     * @return void
     */
    public function setData($element)
    {
        $this->data = $element;
    }

    /**
     * @return void
     */
    public function deleteNext()
    {
        $this->next = null;
    }

    /**
     * @return void
     */
    public function deletePrevius()
    {
        $this->previus = null;
    }

    /**
     * @param Node $node
     * @return void
     */
    public function setNext(Node &$node)
    {
        $this->next = $node;
    }
    
    /**
     * @param Node $node
     * @return void
     */
    public function setPrevius(Node &$node)
    {
        $this->previus = $node;
    }

    /**
     * @return Node
     */
    public function getCurrent()
    {
        return $this;
    }

    /**
     * @param string $data
     * @return Node
     */
    public function new($data = '')
    {
        $new_node = new Node($data);

        if ($this->previus() != null) return false;

        $this->setPrevius($new_node);
        $new_node->setNext($this);

        return $new_node;
    }

    /**
     * @return Node
     */
    public function delete()
    {
        if ($this->next() == null && $this->previus() != null) {
            $node = $this->previus();
            $this->__destruct();
            $node->deleteNext();

            return $node; 
        }

        if ($this->next() != null && $this->previus() == null) {
            $node = $this->next();
            $this->__destruct();
            $node->deletePrevius();
            return $node;
        }

        if ($this->next() != null && $this->previus() != null) {
            $node = $this->previus();
            $this->next()->setPrevius($this->previus());
            $this->previus()->setNext($this->next());
            $this->__destruct();

            return $node;
        }
    }
}

 /**
  * @property protected int $max_size
  * @property protected Node $Node
  * @method public enQueue(string $data): bool
  * @method public deQueue(): void
  * @method public peek(): bool|Node
  * @method public isFull(): bool
  * @method public isEmpty(): bool
  */
class Queue
{
    protected $max_size = 0;
    protected $node = null;

    public function __construct(int $max_size, string $data)
    {
        $this->max_size = $max_size;
        $this->node = new Node($data);
    }

    public function __destruct()
    {
        unset($this->max_size, $this->node);
    }

    /**
     * @param string $data
     * @return bool
     */
    public function enQueue(string $data)
    {
        if ($this->isFull) return false;

        while ($this->node->previus() != null) {
            $this->node = $this->node->previus();
        }

        $this->node = $this->node->new($data);
        
        return true;
    }

    /**
     * @return void|false
     */
    public function deQueue()
    {
        if ($this->isEmpty()) return false;

        while ($this->node->next() != null) {
            $this->node = $this->node->next();
        }

        $this->node->delete();

        while ($this->node->previus() != null) {
            $this->node = $this->node->previus();
        }
    }

    /**
     * @return boolean
     */
    public function isFull()
    {
        $count = 1;
        $node_aux = $this->node;

        while ($node_aux->next() != null) {
            $count++;
            $node_aux = $node_aux->next();
        }

        return ($count == $this->max_size) ? true:false;
    }

    /**
     * @return false|Node
     */
    public function peek()
    {
        if ($this->isEmpty()) return false;

        $node_aux = $this->node;

        while ($node_aux->next() != null) {
            $node_aux = $node_aux->next();
        }

        return $node_aux;
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return ($this->node == null) ? true:false;
    }
}
