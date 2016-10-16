# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## Unreleased
### Added
+ Code coverage annotations in tests

## 0.2.0 [2016-10-16]
### Added
+ ConnectionManager to handling more that one connection
+ NullConnection, NullStatement classes
+ QueryBuilderFactory::registerConnection()
+ QueryFactory to solve the problem with a choice of connection
### Changed
+ QueryBuilder class name to QueryBuilderFactory, and factory methods
now will be prefixed 'create'
+ QueryBuilder::buildQuery() now accepts as a parameter connection name

## 0.1.0 [2016-10-01]
### Added
+ Configuration for travis, scrutinizer, phpunit and composer
+ Initial Connection
+ Initial ParameterManager
+ DI using pimple/pimple
+ Initial ParameterManager
+ QueryBuilder for INSERT, UPDATE, SELECT, DELETE and INSERT ... SELECT
+ QueryCompiler
+ Initial StatementInterface and PDOStatement decorator
+ Table, TableFactory and TableRecognizer for representing database's tables