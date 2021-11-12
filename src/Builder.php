<?php

namespace AndreOrtu\LaravelGoogleAds;

use AndreOrtu\LaravelGoogleAds\Exceptions\BuilderSelectException;
use Illuminate\Support\Str;

trait Builder
{
    protected $where;
    protected $during = "";

    public function getQuery()
    {
        return trim("{$this->getColumns()} {$this->getFrom()} {$this->getWhere()}");
    }

    public function select(array $columns)
    {
        if(count($columns)) {
            $this->columns = $columns;
            return $this;
        }

        return $this;
    }

    public function from(string $from)
    {
        if($from) {
            $this->report_name = $from;
            return $this;
        }

        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->where .= "$column $operator $value AND";
        return $this;
    }

    public function setDuring($during)
    {
        $this->during = "segments.date BETWEEN '{$during[0]}' AND '{$during[1]}'";
        return $this;
    }

    public function getWhere()
    {
        $during = $this->during === "" ? "segments.date DURING $this->date" : $this->during;
        if($this->where) {
            $where = Str::replaceLast("AND", "", $this->where);
            return "WHERE $during AND $where";
        }
        return "WHERE $during";
    }

    private function getColumns()
    {
        $columns = implode(",", $this->columns);
        return "SELECT $columns";
    }

    private function getFrom()
    {
        return "FROM $this->report_name";
    }
}
