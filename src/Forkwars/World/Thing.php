<?php

namespace Forkwars\World;

use Forkwars\Position;

/**
 * A thing is part of a World, got a position on it, and which is sometimes part of a team.
 *
 * Everything is a Thing.
 */
class Thing
{
    private $children = null;

    private $parent = null;

    private $position = null;

    /**
     * @param Thing $parent
     * @return $this
     */
    public function setParent(Thing $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return null|Thing
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return Thing[]
     */
    public function getChildren()
    {
        if(is_null($this->children)){
            $this->children = new \SplObjectStorage();
        }
        return $this->children;
    }

    /**
     * Add a child to $this and sets the child's parent.
     * @param Thing $child
     */
    public function addChild(Thing $child)
    {
        $this->getChildren()->attach($child);
        $child->setParent($this);
    }

    /**
     * Remove the child and makes the child orphan.
     * @param Thing $child
     */
    public function removeChild(Thing $child)
    {
        $this->getChildren()->detach($child);
        $child->setParent(null);
    }

    /**
     * @param Thing $parent
     */
    public function attachTo(Thing $parent)
    {
        $this->setParent($parent);
        $parent->getChildren()->attach($this);
        return $this;
    }

    /**
     *
     */
    public function detach()
    {
        $this->getParent()->getChildren()->detach($this);
        $this->setParent(null);
        return $this;
    }

    public function __sleep()
    {
        // Deal with circular references.
        $this->parent = null;
    }

    public function getPosition()
    {
        if(is_null($this->position)){
            throw new \Exception('This thing has no position');
        }
        return $this->position;
    }

    /**
     * @param Position $position
     * @return $this Fluent
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;
        return $this;
    }

    public function registerAction()
    {
        throw new \Exception('Cannot register action');
    }

    public function registerReference()
    {
        throw new \Exception('Cannot register reference');
    }
}
