<?php
/**
 * Board
 *
 * @package Freeboard
 * @author  Christoph Frenes <c.frenes@reply.de>
 */
namespace Freeboard;

class Board
{
    /**
     * @var stdClass
     */
    protected $_board;

    protected function _setBoard($boardData)
    {
        if (is_object($boardData) && $boardData->name && $boardData->data) {
            $this->_board = $boardData;
            return true;
        }

        return false;
    }

    public function setBoardByJsonString($json = '')
    {
        if (!empty($json) && $this->_setBoard(json_decode($json))) {
            return true;
        }

        return false;
    }

    public function setBoardByFile($file = '')
    {
        if (file_exists($file) && $this->_setBoard(json_decode(file_get_contents($file)))) {
            return true;
        }

        return false;
    }

    public function getBoard()
    {
        if (!empty($this->_board)) {
            return $this->_board;
        }

        return false;
    }

    public function getName()
    {
        if ($this->getBoard()) {
            return $this->getBoard()->name;
        } else {
            return 'n/a';
        }
    }

    public function getData()
    {
        if ($this->getBoard()) {
            return json_encode($this->getBoard()->data);
        }
    }

    public function save($filename = '')
    {
        if (!$this->getBoard()) {
            return false;
        }

        if (!is_writeable(Freeboard::getBaseDir('boards'))) {
            return false;
        }

        $boardData = sprintf(
            '{ "name": "%s", "data": %s }',
            $this->getName(),
            $this->getData()
        );

        if (file_put_contents(Freeboard::getBaseDir('boards') . $filename, $boardData)) {
            return true;
        }

        return false;
    }

    public function delete($filename = '')
    {
        if (!$this->getBoard()) {
            return false;
        }

        if (!is_writeable(Freeboard::getBaseDir('boards'))) {
            return false;
        }

        if (unlink(Freeboard::getBaseDir('boards') . $filename)) {
            return true;
        }

        return false;
    }
}