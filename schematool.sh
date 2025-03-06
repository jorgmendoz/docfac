#!/bin/bash
set -e
sleep 5
vendor/bin/doctrine orm:schema-tool:create || true
apache2-foreground
