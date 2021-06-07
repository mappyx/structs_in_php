<?php
/**
 * @author Rafael Jose Paez Villanueva
 * @email jugamus@gmail.com
 * @github /varcangel
 * @version 1.0
 * @description This is a model of a data structure known as a doubly linked list
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
     * @return string
     */
    public function getData()
    {
        return $this->data ?? '';
    }

    /**
     * @return Node
     */
    public function getCurrent()
    {
        return $this;
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
     * @param string $element
     * @return void
     */
    public function setData($element)
    {
        $this->data = $element;
    }

    /**
     * @param string $data
     * @return Node
     */
    public function new($data = '')
    {
        $new_node = new Node($data);
        $this->setNext($new_node);
        $new_node->setPrevius($this);

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
     * @return Node|null
     */
    public function search($element)
    {
        $node = $this->getCurrent();
        while ($node->next() != null) {
            if ($element == $node->getData()) {
                return $node;
            }

            $node = $node->next();
        }

        return null;
    }
}
