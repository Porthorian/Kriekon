<?php
/**
 * @author erusev
 * @reference https://github.com/erusev/parsedown
 * @note Some of the variables and functions are renamed
 */

class Markdown
{
  const version = '1.0.0';

  protected $breaksEnabled,     // Setter #1
            $markupEscaped,     // Setter #2
            $urlsLinked = true, // Setter #3
            $unmarkedBlockTypes = array('Code',), // Setter #4
            // Lines
            $blockTypes = array(
              '#' => array('Header'),
              '*' => array('Rule', 'List'),
              '+' => array('List'),
              '-' => array('SetextHeader', 'Table', 'Rule', 'List'),
              '0' => array('List'),
              '1' => array('List'),
              '2' => array('List'),
              '3' => array('List'),
              '4' => array('List'),
              '5' => array('List'),
              '6' => array('List'),
              '7' => array('List'),
              '8' => array('List'),
              '9' => array('List'),
              ':' => array('Table'),
              '<' => array('Comment', 'Markup'),
              '=' => array('SetextHeader'),
              '>' => array('Quote'),
              '[' => array('Reference'),
              '_' => array('Rule'),
              '`' => array('FencedCode'),
              '|' => array('Table'),
              '~' => array('FencedCode'),
            );

  function text($text)
  {
    //No defs set
    $this->DefData = array();

    // Standardized line breaks
    $text = str_replace(array("\r\n", "\r"), "\n", $text);

    // Remove line breaks
    $text = trim($text, "\n");

    // Split lines
    $lines = explode("\n", $text);

    // Identify Blocks
    $markup = $this->lines($lines);

    // Remove line breaks
    $markup = trim($markup, "\n");

    return $markup;
  }

  /**
   * Enablers
   */

  function setBreaksEnabled($breaksEnabled)
  {
    $this->breaksEnabled = $breaksEnabled;
    return $this;
  }

  function setMarkupEscaped($markupEscaped)
  {
    $this->markupEscaped = $markupEscaped;
    return $this;
  }

  function setUrlsLinked($urlsLinked)
  {
    $this->urlsLinked = $urlsLinked;
    return $this;
  }

  /**
   * Blocks
   */

  protected function lines(array $lines)
  {
    $currentBlock = null;

    foreach ($lines as $line) {
      if(chop($line) === '') {
        if(isset($currentBlock)) {
          $currentBlock['interrupted'] = true;
        }
        continue;
      }

      if(strpos($line, "\t") !== false) {
        $parts = explode("\t", $line);
        $line = $parts[0];
        unset($parts[0]);

        foreach ($parts as $part) {
          $shortage = 4 - mb_strlen($line, 'UTF-8') % 4;
          $line .= str_repeat(' ', $shortage);
          $line .= $part;
        }
      }

      $indent =0;

      while (isset($line[$indent]) and $line[$indent] === ' ')
      {
        $indent++;
      }

      $text = $indent > 0 ? substr($line, $indent) : $line;

      $Line = array(
        'body' => $line,
        'indent' => $indent,
        'text' => $text
      );

      if(isset($currentBlock['continuable'])) {
        $Block = $this->{'block'.$currentBlock['type'].'Continue'}($Line, $currentBlock);

        if(isset($Block)) {
          $currentBlock = $Block;
          continue;
        }
        else {
          if($this->isBlockCompletable($currentBlock['type'])) {
            $currentBlock = $this->{'block'.$currentBlock['type'].'Complete'}($currentBlock);
          }
        }
      }
      ####
    }
  }
}
