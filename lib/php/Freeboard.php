<?php
namespace Freeboard;

require_once 'Freeboard/Board.php';

/**
 * Server side functionality for Freeboard
 *
 * @package Freeboard
 * @author  Christoph Frenes <c.frenes@reply.de>
 *
 * @todo exclude board from here and make it an own class
 */
class Freeboard
{
    /**
     * @var Board
     */
    protected $_board;

    /**
     * @var array
     */
    protected $_boardList;

    /**
     * default settings
     */
    public function __construct()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $this->_board = new Board();
        $this->setBoard();
    }

    /**
     * get project paths
     *
     * @param string $type
     * @return string
     */
    static public function getBaseDir($type = '')
    {
        $application = dirname(dirname(dirname(__FILE__)));

        switch ($type) {
            case 'boards': return $application . DIRECTORY_SEPARATOR . 'boards' . DIRECTORY_SEPARATOR;
            case 'images': return $application . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        }

        return $application . DIRECTORY_SEPARATOR;
    }

    public function isJson($str)
    {
        return is_string($str) && is_object(json_decode($str)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    /**
     * set board object
     *
     * @param $board string filename of a board including .json ending
     * @return bool|mixed
     */
    public function setBoard($board = '')
    {
        if ($this->isJson($board)) {
            $this->_board->setBoardByJsonString($board);
        } else {
            if (empty($board) && isset($_GET['board'])) {
                $board = $_GET['board'];
            }

            if (!empty($board)) {
                $board = urlencode($board);
                $bFile = self::getBaseDir('boards') . $board;
                $this->_board->setBoardByFile($bFile);
            }
        }
    }

    /**
     * get board object
     *
     * @return bool|Board
     */
    public function getBoard()
    {
        if (!empty($this->_board)) {
            return $this->_board;
        }

        return false;
    }

    /**
     * set list of boards
     *
     * @return array
     */
    public function _setBoardList()
    {
        $boards = array();

        $boardFiles = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                self::getBaseDir('boards'),
                \RecursiveDirectoryIterator::SKIP_DOTS
            )
        );

        if (empty($boardFiles)) {
            return $boards;
        }

        foreach ($boardFiles AS $boardFile) {
            $board = new Board();
            $board->setBoardByFile($boardFile);

            $boards[] = array(
                'file' => $boardFile->getFilename(),
                'name' => $board->getName()
            );
        }

        $this->_boardList = $boards;
        return $this->_boardList;
    }

    /**
     * get a list of all boards
     *
     * @return array
     */
    public function getBoardList()
    {
        if (empty($this->_boardList)) {
            $this->_setBoardList();
        }

        return $this->_boardList;
    }
}

// init Freeboard
$freeboard = new Freeboard();