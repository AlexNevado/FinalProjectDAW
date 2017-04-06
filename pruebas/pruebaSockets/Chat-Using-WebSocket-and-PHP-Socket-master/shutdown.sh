#!/bin/bash
echo "**Stopping server**"
pid=pstree |grep php
echo $pid
kill pid