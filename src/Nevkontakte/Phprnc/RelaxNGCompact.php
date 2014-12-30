<?php

namespace Nevkontakte\Phprnc;

class RelaxNGCompact
{
    protected $string;
    protected $position;
    protected $value;
    protected $cache;
    protected $cut;
    protected $errors;
    protected $warnings;

    protected function parseSchemaFile()
    {
        $_position = $this->position;

        if (isset($this->cache['SchemaFile'][$_position])) {
            $_success = $this->cache['SchemaFile'][$_position]['success'];
            $this->position = $this->cache['SchemaFile'][$_position]['position'];
            $this->value = $this->cache['SchemaFile'][$_position]['value'];

            return $_success;
        }

        $_position1 = $this->position;
        $_cut2 = $this->cut;

        $this->cut = false;
        $_success = $this->parseLiteral();

        if (!$_success && !$this->cut) {
            $this->position = $_position1;

            $_success = $this->parseNsName();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position1;

            $_success = $this->parseCName();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position1;

            $_success = $this->parseInherit();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position1;

            $_success = $this->parseNameClass();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position1;

            $_success = $this->parseIdentifierOrKeyword();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position1;

            $_success = $this->parseNCName();
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position1;

            $_success = $this->parseAnyName();
        }

        $this->cut = $_cut2;

        $this->cache['SchemaFile'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'SchemaFile');
        }

        return $_success;
    }

    protected function parseNameClass()
    {
        $_position = $this->position;

        if (isset($this->cache['NameClass'][$_position])) {
            $_success = $this->cache['NameClass'][$_position]['success'];
            $this->position = $this->cache['NameClass'][$_position]['position'];
            $this->value = $this->cache['NameClass'][$_position]['value'];

            return $_success;
        }

        $_position11 = $this->position;
        $_cut12 = $this->cut;

        $this->cut = false;
        $_success = $this->parseName();

        if (!$_success && !$this->cut) {
            $this->position = $_position11;

            $_value3 = array();

            if (substr($this->string, $this->position, strlen("(")) === "(") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("("));
                $this->position += strlen("(");
            } else {
                $_success = false;

                $this->report($this->position, '"("');
            }

            if ($_success) {
                $_value3[] = $this->value;

                $_success = $this->parse_();
            }

            if ($_success) {
                $_value3[] = $this->value;

                $_success = $this->parseNameClass();
            }

            if ($_success) {
                $_value3[] = $this->value;

                $_success = $this->parse_();
            }

            if ($_success) {
                $_value3[] = $this->value;

                if (substr($this->string, $this->position, strlen(")")) === ")") {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, strlen(")"));
                    $this->position += strlen(")");
                } else {
                    $_success = false;

                    $this->report($this->position, '")"');
                }
            }

            if ($_success) {
                $_value3[] = $this->value;

                $this->value = $_value3;
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position11;

            $_value4 = array();

            $_success = $this->parseNameClass();

            if ($_success) {
                $_value4[] = $this->value;

                $_success = $this->parse_();
            }

            if ($_success) {
                $_value4[] = $this->value;

                if (substr($this->string, $this->position, strlen("|")) === "|") {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, strlen("|"));
                    $this->position += strlen("|");
                } else {
                    $_success = false;

                    $this->report($this->position, '"|"');
                }
            }

            if ($_success) {
                $_value4[] = $this->value;

                $_success = $this->parse_();
            }

            if ($_success) {
                $_value4[] = $this->value;

                $_success = $this->parseNameClass();
            }

            if ($_success) {
                $_value4[] = $this->value;

                $this->value = $_value4;
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position11;

            $_value7 = array();

            $_success = $this->parseNsName();

            if ($_success) {
                $_value7[] = $this->value;

                $_position5 = $this->position;
                $_cut6 = $this->cut;

                $this->cut = false;
                $_success = $this->parseExceptNameClass();

                if (!$_success && !$this->cut) {
                    $_success = true;
                    $this->position = $_position5;
                    $this->value = null;
                }

                $this->cut = $_cut6;
            }

            if ($_success) {
                $_value7[] = $this->value;

                $this->value = $_value7;
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position11;

            $_value10 = array();

            $_success = $this->parseAnyName();

            if ($_success) {
                $_value10[] = $this->value;

                $_position8 = $this->position;
                $_cut9 = $this->cut;

                $this->cut = false;
                $_success = $this->parseExceptNameClass();

                if (!$_success && !$this->cut) {
                    $_success = true;
                    $this->position = $_position8;
                    $this->value = null;
                }

                $this->cut = $_cut9;
            }

            if ($_success) {
                $_value10[] = $this->value;

                $this->value = $_value10;
            }
        }

        $this->cut = $_cut12;

        if ($_success) {
            $this->value = call_user_func(function () {
                return "NameClass";
            });
        }

        $this->cache['NameClass'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'NameClass');
        }

        return $_success;
    }

    protected function parseName()
    {
        $_position = $this->position;

        if (isset($this->cache['Name'][$_position])) {
            $_success = $this->cache['Name'][$_position]['success'];
            $this->position = $this->cache['Name'][$_position]['position'];
            $this->value = $this->cache['Name'][$_position]['value'];

            return $_success;
        }

        $_position13 = $this->position;
        $_cut14 = $this->cut;

        $this->cut = false;
        $_success = $this->parseIdentifierOrKeyword();

        if (!$_success && !$this->cut) {
            $this->position = $_position13;

            $_success = $this->parseCName();
        }

        $this->cut = $_cut14;

        $this->cache['Name'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'Name');
        }

        return $_success;
    }

    protected function parseExceptNameClass()
    {
        $_position = $this->position;

        if (isset($this->cache['ExceptNameClass'][$_position])) {
            $_success = $this->cache['ExceptNameClass'][$_position]['success'];
            $this->position = $this->cache['ExceptNameClass'][$_position]['position'];
            $this->value = $this->cache['ExceptNameClass'][$_position]['value'];

            return $_success;
        }

        $_value15 = array();

        if (substr($this->string, $this->position, strlen("-")) === "-") {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen("-"));
            $this->position += strlen("-");
        } else {
            $_success = false;

            $this->report($this->position, '"-"');
        }

        if ($_success) {
            $_value15[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value15[] = $this->value;

            $_success = $this->parseNameClass();
        }

        if ($_success) {
            $_value15[] = $this->value;

            $this->value = $_value15;
        }

        $this->cache['ExceptNameClass'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'ExceptNameClass');
        }

        return $_success;
    }

    protected function parseDatatypeName()
    {
        $_position = $this->position;

        if (isset($this->cache['DatatypeName'][$_position])) {
            $_success = $this->cache['DatatypeName'][$_position]['success'];
            $this->position = $this->cache['DatatypeName'][$_position]['position'];
            $this->value = $this->cache['DatatypeName'][$_position]['value'];

            return $_success;
        }

        $_position16 = $this->position;
        $_cut17 = $this->cut;

        $this->cut = false;
        $_success = $this->parseCName();

        if (!$_success && !$this->cut) {
            $this->position = $_position16;

            if (substr($this->string, $this->position, strlen("string")) === "string") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("string"));
                $this->position += strlen("string");
            } else {
                $_success = false;

                $this->report($this->position, '"string"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position16;

            if (substr($this->string, $this->position, strlen("token")) === "token") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("token"));
                $this->position += strlen("token");
            } else {
                $_success = false;

                $this->report($this->position, '"token"');
            }
        }

        $this->cut = $_cut17;

        $this->cache['DatatypeName'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'DatatypeName');
        }

        return $_success;
    }

    protected function parseDatatypeValue()
    {
        $_position = $this->position;

        if (isset($this->cache['DatatypeValue'][$_position])) {
            $_success = $this->cache['DatatypeValue'][$_position]['success'];
            $this->position = $this->cache['DatatypeValue'][$_position]['position'];
            $this->value = $this->cache['DatatypeValue'][$_position]['value'];

            return $_success;
        }

        $_success = $this->parseLiteral();

        $this->cache['DatatypeValue'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'DatatypeValue');
        }

        return $_success;
    }

    protected function parseAnyURILiteral()
    {
        $_position = $this->position;

        if (isset($this->cache['AnyURILiteral'][$_position])) {
            $_success = $this->cache['AnyURILiteral'][$_position]['success'];
            $this->position = $this->cache['AnyURILiteral'][$_position]['position'];
            $this->value = $this->cache['AnyURILiteral'][$_position]['value'];

            return $_success;
        }

        $_success = $this->parseLiteral();

        $this->cache['AnyURILiteral'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'AnyURILiteral');
        }

        return $_success;
    }

    protected function parseNamespaceURILiteral()
    {
        $_position = $this->position;

        if (isset($this->cache['NamespaceURILiteral'][$_position])) {
            $_success = $this->cache['NamespaceURILiteral'][$_position]['success'];
            $this->position = $this->cache['NamespaceURILiteral'][$_position]['position'];
            $this->value = $this->cache['NamespaceURILiteral'][$_position]['value'];

            return $_success;
        }

        $_success = $this->parseLiteral();

        $this->cache['NamespaceURILiteral'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'NamespaceURILiteral');
        }

        return $_success;
    }

    protected function parseInherit()
    {
        $_position = $this->position;

        if (isset($this->cache['Inherit'][$_position])) {
            $_success = $this->cache['Inherit'][$_position]['success'];
            $this->position = $this->cache['Inherit'][$_position]['position'];
            $this->value = $this->cache['Inherit'][$_position]['value'];

            return $_success;
        }

        $_value18 = array();

        if (substr($this->string, $this->position, strlen("inherit")) === "inherit") {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen("inherit"));
            $this->position += strlen("inherit");
        } else {
            $_success = false;

            $this->report($this->position, '"inherit"');
        }

        if ($_success) {
            $_value18[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value18[] = $this->value;

            if (substr($this->string, $this->position, strlen("=")) === "=") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("="));
                $this->position += strlen("=");
            } else {
                $_success = false;

                $this->report($this->position, '"="');
            }
        }

        if ($_success) {
            $_value18[] = $this->value;

            $_success = $this->parse_();
        }

        if ($_success) {
            $_value18[] = $this->value;

            $_success = $this->parseIdentifierOrKeyword();
        }

        if ($_success) {
            $_value18[] = $this->value;

            $this->value = $_value18;
        }

        $this->cache['Inherit'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'Inherit');
        }

        return $_success;
    }

    protected function parseIdentifierOrKeyword()
    {
        $_position = $this->position;

        if (isset($this->cache['IdentifierOrKeyword'][$_position])) {
            $_success = $this->cache['IdentifierOrKeyword'][$_position]['success'];
            $this->position = $this->cache['IdentifierOrKeyword'][$_position]['position'];
            $this->value = $this->cache['IdentifierOrKeyword'][$_position]['value'];

            return $_success;
        }

        $_position19 = $this->position;
        $_cut20 = $this->cut;

        $this->cut = false;
        $_success = $this->parseIdentifier();

        if (!$_success && !$this->cut) {
            $this->position = $_position19;

            $_success = $this->parseKeyword();
        }

        $this->cut = $_cut20;

        $this->cache['IdentifierOrKeyword'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'IdentifierOrKeyword');
        }

        return $_success;
    }

    protected function parseIdentifier()
    {
        $_position = $this->position;

        if (isset($this->cache['Identifier'][$_position])) {
            $_success = $this->cache['Identifier'][$_position]['success'];
            $this->position = $this->cache['Identifier'][$_position]['position'];
            $this->value = $this->cache['Identifier'][$_position]['value'];

            return $_success;
        }

        $_position24 = $this->position;
        $_cut25 = $this->cut;

        $this->cut = false;
        $_value23 = array();

        $_position21 = $this->position;
        $_cut22 = $this->cut;

        $this->cut = false;
        $_success = $this->parseKeyword();

        if (!$_success) {
            $_success = true;
            $this->value = null;
        } else {
            $_success = false;
        }

        $this->position = $_position21;
        $this->cut = $_cut22;

        if ($_success) {
            $_value23[] = $this->value;

            $_success = $this->parseNCName();
        }

        if ($_success) {
            $_value23[] = $this->value;

            $this->value = $_value23;
        }

        if ($_success) {
            $this->value = call_user_func(function () {
                return "identifier";
            });
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position24;

            $_success = $this->parseQuotedIdentifier();
        }

        $this->cut = $_cut25;

        $this->cache['Identifier'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'Identifier');
        }

        return $_success;
    }

    protected function parseQuotedIdentifier()
    {
        $_position = $this->position;

        if (isset($this->cache['QuotedIdentifier'][$_position])) {
            $_success = $this->cache['QuotedIdentifier'][$_position]['success'];
            $this->position = $this->cache['QuotedIdentifier'][$_position]['position'];
            $this->value = $this->cache['QuotedIdentifier'][$_position]['value'];

            return $_success;
        }

        $_value26 = array();

        if (substr($this->string, $this->position, strlen("\\")) === "\\") {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen("\\"));
            $this->position += strlen("\\");
        } else {
            $_success = false;

            $this->report($this->position, '"\\\\"');
        }

        if ($_success) {
            $_value26[] = $this->value;

            $_success = $this->parseNCName();
        }

        if ($_success) {
            $_value26[] = $this->value;

            $this->value = $_value26;
        }

        $this->cache['QuotedIdentifier'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'QuotedIdentifier');
        }

        return $_success;
    }

    protected function parseCName()
    {
        $_position = $this->position;

        if (isset($this->cache['CName'][$_position])) {
            $_success = $this->cache['CName'][$_position]['success'];
            $this->position = $this->cache['CName'][$_position]['position'];
            $this->value = $this->cache['CName'][$_position]['value'];

            return $_success;
        }

        $_value27 = array();

        $_success = $this->parseNCName();

        if ($_success) {
            $_value27[] = $this->value;

            if (substr($this->string, $this->position, strlen(":")) === ":") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen(":"));
                $this->position += strlen(":");
            } else {
                $_success = false;

                $this->report($this->position, '":"');
            }
        }

        if ($_success) {
            $_value27[] = $this->value;

            $_success = $this->parseNCName();
        }

        if ($_success) {
            $_value27[] = $this->value;

            $this->value = $_value27;
        }

        $this->cache['CName'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'CName');
        }

        return $_success;
    }

    protected function parseNsName()
    {
        $_position = $this->position;

        if (isset($this->cache['NsName'][$_position])) {
            $_success = $this->cache['NsName'][$_position]['success'];
            $this->position = $this->cache['NsName'][$_position]['position'];
            $this->value = $this->cache['NsName'][$_position]['value'];

            return $_success;
        }

        $_value28 = array();

        $_success = $this->parseNCName();

        if ($_success) {
            $_value28[] = $this->value;

            if (substr($this->string, $this->position, strlen(":*")) === ":*") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen(":*"));
                $this->position += strlen(":*");
            } else {
                $_success = false;

                $this->report($this->position, '":*"');
            }
        }

        if ($_success) {
            $_value28[] = $this->value;

            $this->value = $_value28;
        }

        $this->cache['NsName'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'NsName');
        }

        return $_success;
    }

    protected function parseAnyName()
    {
        $_position = $this->position;

        if (isset($this->cache['AnyName'][$_position])) {
            $_success = $this->cache['AnyName'][$_position]['success'];
            $this->position = $this->cache['AnyName'][$_position]['position'];
            $this->value = $this->cache['AnyName'][$_position]['value'];

            return $_success;
        }

        if (substr($this->string, $this->position, strlen("*")) === "*") {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen("*"));
            $this->position += strlen("*");
        } else {
            $_success = false;

            $this->report($this->position, '"*"');
        }

        $this->cache['AnyName'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'AnyName');
        }

        return $_success;
    }

    protected function parseNCName()
    {
        $_position = $this->position;

        if (isset($this->cache['NCName'][$_position])) {
            $_success = $this->cache['NCName'][$_position]['success'];
            $this->position = $this->cache['NCName'][$_position]['position'];
            $this->value = $this->cache['NCName'][$_position]['value'];

            return $_success;
        }

        $_position32 = $this->position;

        if (preg_match('/^[a-zA-Z0-9._-]$/', substr($this->string, $this->position, 1))) {
            $_success = true;
            $this->value = substr($this->string, $this->position, 1);
            $this->position += 1;
        } else {
            $_success = false;
        }

        if ($_success) {
            $_value30 = array($this->value);
            $_cut31 = $this->cut;

            while (true) {
                $_position29 = $this->position;

                $this->cut = false;
                if (preg_match('/^[a-zA-Z0-9._-]$/', substr($this->string, $this->position, 1))) {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, 1);
                    $this->position += 1;
                } else {
                    $_success = false;
                }

                if (!$_success) {
                    break;
                }

                $_value30[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position29;
                $this->value = $_value30;
            }

            $this->cut = $_cut31;
        }

        if ($_success) {
            $this->value = strval(substr($this->string, $_position32, $this->position - $_position32));
        }

        $this->cache['NCName'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'NCName');
        }

        return $_success;
    }

    protected function parseLiteral()
    {
        $_position = $this->position;

        if (isset($this->cache['Literal'][$_position])) {
            $_success = $this->cache['Literal'][$_position]['success'];
            $this->position = $this->cache['Literal'][$_position]['position'];
            $this->value = $this->cache['Literal'][$_position]['value'];

            return $_success;
        }

        $_value37 = array();

        $_success = $this->parseLiteralSegment();

        if ($_success) {
            $_value37[] = $this->value;

            $_value35 = array();
            $_cut36 = $this->cut;

            while (true) {
                $_position34 = $this->position;

                $this->cut = false;
                $_value33 = array();

                $_success = $this->parse_();

                if ($_success) {
                    $_value33[] = $this->value;

                    if (substr($this->string, $this->position, strlen("~")) === "~") {
                        $_success = true;
                        $this->value = substr($this->string, $this->position, strlen("~"));
                        $this->position += strlen("~");
                    } else {
                        $_success = false;

                        $this->report($this->position, '"~"');
                    }
                }

                if ($_success) {
                    $_value33[] = $this->value;

                    $_success = $this->parse_();
                }

                if ($_success) {
                    $_value33[] = $this->value;

                    $_success = $this->parseLiteralSegment();
                }

                if ($_success) {
                    $_value33[] = $this->value;

                    $this->value = $_value33;
                }

                if (!$_success) {
                    break;
                }

                $_value35[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position34;
                $this->value = $_value35;
            }

            $this->cut = $_cut36;
        }

        if ($_success) {
            $_value37[] = $this->value;

            $this->value = $_value37;
        }

        $this->cache['Literal'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'Literal');
        }

        return $_success;
    }

    protected function parseLiteralSegment()
    {
        $_position = $this->position;

        if (isset($this->cache['LiteralSegment'][$_position])) {
            $_success = $this->cache['LiteralSegment'][$_position]['success'];
            $this->position = $this->cache['LiteralSegment'][$_position]['position'];
            $this->value = $this->cache['LiteralSegment'][$_position]['value'];

            return $_success;
        }

        $_value42 = array();

        if (substr($this->string, $this->position, strlen('"')) === '"') {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen('"'));
            $this->position += strlen('"');
        } else {
            $_success = false;

            $this->report($this->position, '\'"\'');
        }

        if ($_success) {
            $_value42[] = $this->value;

            $_position41 = $this->position;

            $_value39 = array();
            $_cut40 = $this->cut;

            while (true) {
                $_position38 = $this->position;

                $this->cut = false;
                if (preg_match('/^[^"\\n]$/', substr($this->string, $this->position, 1))) {
                    $_success = true;
                    $this->value = substr($this->string, $this->position, 1);
                    $this->position += 1;
                } else {
                    $_success = false;
                }

                if (!$_success) {
                    break;
                }

                $_value39[] = $this->value;
            }

            if (!$this->cut) {
                $_success = true;
                $this->position = $_position38;
                $this->value = $_value39;
            }

            $this->cut = $_cut40;

            if ($_success) {
                $this->value = strval(substr($this->string, $_position41, $this->position - $_position41));
            }
        }

        if ($_success) {
            $_value42[] = $this->value;

            if (substr($this->string, $this->position, strlen('"')) === '"') {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen('"'));
                $this->position += strlen('"');
            } else {
                $_success = false;

                $this->report($this->position, '\'"\'');
            }
        }

        if ($_success) {
            $_value42[] = $this->value;

            $this->value = $_value42;
        }

        $this->cache['LiteralSegment'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'LiteralSegment');
        }

        return $_success;
    }

    protected function parseKeyword()
    {
        $_position = $this->position;

        if (isset($this->cache['Keyword'][$_position])) {
            $_success = $this->cache['Keyword'][$_position]['success'];
            $this->position = $this->cache['Keyword'][$_position]['position'];
            $this->value = $this->cache['Keyword'][$_position]['value'];

            return $_success;
        }

        $_position43 = $this->position;
        $_cut44 = $this->cut;

        $this->cut = false;
        if (substr($this->string, $this->position, strlen("attribute")) === "attribute") {
            $_success = true;
            $this->value = substr($this->string, $this->position, strlen("attribute"));
            $this->position += strlen("attribute");
        } else {
            $_success = false;

            $this->report($this->position, '"attribute"');
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("default")) === "default") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("default"));
                $this->position += strlen("default");
            } else {
                $_success = false;

                $this->report($this->position, '"default"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("datatypes")) === "datatypes") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("datatypes"));
                $this->position += strlen("datatypes");
            } else {
                $_success = false;

                $this->report($this->position, '"datatypes"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("div")) === "div") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("div"));
                $this->position += strlen("div");
            } else {
                $_success = false;

                $this->report($this->position, '"div"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("element")) === "element") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("element"));
                $this->position += strlen("element");
            } else {
                $_success = false;

                $this->report($this->position, '"element"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("empty")) === "empty") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("empty"));
                $this->position += strlen("empty");
            } else {
                $_success = false;

                $this->report($this->position, '"empty"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("external")) === "external") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("external"));
                $this->position += strlen("external");
            } else {
                $_success = false;

                $this->report($this->position, '"external"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("grammar")) === "grammar") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("grammar"));
                $this->position += strlen("grammar");
            } else {
                $_success = false;

                $this->report($this->position, '"grammar"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("include")) === "include") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("include"));
                $this->position += strlen("include");
            } else {
                $_success = false;

                $this->report($this->position, '"include"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("inherit")) === "inherit") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("inherit"));
                $this->position += strlen("inherit");
            } else {
                $_success = false;

                $this->report($this->position, '"inherit"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("list")) === "list") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("list"));
                $this->position += strlen("list");
            } else {
                $_success = false;

                $this->report($this->position, '"list"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("mixed")) === "mixed") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("mixed"));
                $this->position += strlen("mixed");
            } else {
                $_success = false;

                $this->report($this->position, '"mixed"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("namespace")) === "namespace") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("namespace"));
                $this->position += strlen("namespace");
            } else {
                $_success = false;

                $this->report($this->position, '"namespace"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("notAllowed")) === "notAllowed") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("notAllowed"));
                $this->position += strlen("notAllowed");
            } else {
                $_success = false;

                $this->report($this->position, '"notAllowed"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("parent")) === "parent") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("parent"));
                $this->position += strlen("parent");
            } else {
                $_success = false;

                $this->report($this->position, '"parent"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("start")) === "start") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("start"));
                $this->position += strlen("start");
            } else {
                $_success = false;

                $this->report($this->position, '"start"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("string")) === "string") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("string"));
                $this->position += strlen("string");
            } else {
                $_success = false;

                $this->report($this->position, '"string"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("text")) === "text") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("text"));
                $this->position += strlen("text");
            } else {
                $_success = false;

                $this->report($this->position, '"text"');
            }
        }

        if (!$_success && !$this->cut) {
            $this->position = $_position43;

            if (substr($this->string, $this->position, strlen("token")) === "token") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen("token"));
                $this->position += strlen("token");
            } else {
                $_success = false;

                $this->report($this->position, '"token"');
            }
        }

        $this->cut = $_cut44;

        if ($_success) {
            $this->value = call_user_func(function () {
                return "keyword";
            });
        }

        $this->cache['Keyword'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, 'Keyword');
        }

        return $_success;
    }

    protected function parse_()
    {
        $_position = $this->position;

        if (isset($this->cache['_'][$_position])) {
            $_success = $this->cache['_'][$_position]['success'];
            $this->position = $this->cache['_'][$_position]['position'];
            $this->value = $this->cache['_'][$_position]['value'];

            return $_success;
        }

        $_value46 = array();
        $_cut47 = $this->cut;

        while (true) {
            $_position45 = $this->position;

            $this->cut = false;
            if (substr($this->string, $this->position, strlen(" ")) === " ") {
                $_success = true;
                $this->value = substr($this->string, $this->position, strlen(" "));
                $this->position += strlen(" ");
            } else {
                $_success = false;

                $this->report($this->position, '" "');
            }

            if (!$_success) {
                break;
            }

            $_value46[] = $this->value;
        }

        if (!$this->cut) {
            $_success = true;
            $this->position = $_position45;
            $this->value = $_value46;
        }

        $this->cut = $_cut47;

        $this->cache['_'][$_position] = array(
            'success' => $_success,
            'position' => $this->position,
            'value' => $this->value
        );

        if (!$_success) {
            $this->report($_position, '_');
        }

        return $_success;
    }

    private function line()
    {
        return count(explode("\n", substr($this->string, 0, $this->position)));
    }

    private function rest()
    {
        return '"' . substr($this->string, $this->position) . '"';
    }

    protected function report($position, $expecting)
    {
        if ($this->cut) {
            $this->errors[$position][] = $expecting;
        } else {
            $this->warnings[$position][] = $expecting;
        }
    }

    private function expecting()
    {
        if (!empty($this->errors)) {
            ksort($this->errors);

            return end($this->errors)[0];
        }

        ksort($this->warnings);

        return implode(', ', end($this->warnings));
    }

    public function parse($_string)
    {
        $this->string = $_string;
        $this->position = 0;
        $this->value = null;
        $this->cache = array();
        $this->cut = false;
        $this->errors = array();
        $this->warnings = array();

        $_success = $this->parseSchemaFile();

        if (!$_success) {
            throw new \InvalidArgumentException("Syntax error, expecting {$this->expecting()} on line {$this->line()}");
        }

        if ($this->position < strlen($this->string)) {
            throw new \InvalidArgumentException("Syntax error, unexpected {$this->rest()} on line {$this->line()}");
        }

        return $this->value;
    }
}