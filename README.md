<h1 align="center">CI/CD example</h1>

<p align="center">
	<img src="https://github.com/robiningelbrecht/continuous-integration-example/raw/master/readme/ci.png" alt="CI/CD">
</p>

<p align="center">
<a href="https://github.com/robiningelbrecht/continuous-integration-example/actions/workflows/ci-cd.yml"><img src="https://github.com/robiningelbrecht/continuous-integration-example/actions/workflows/ci-cd.yml/badge.svg" alt="CI/CD"></a>
<a href="https://codecov.io/gh/robiningelbrecht/continuous-integration-example"><img src="https://codecov.io/gh/robiningelbrecht/continuous-integration-example/branch/master/graph/badge.svg?token=9FEMHIZTZ0" alt="codecov.io"></a>
<a href="https://choosealicense.com/licenses/mit/"><img src="https://img.shields.io/github/license/robiningelbrecht/continuous-integration-example" alt="License"></a>
<a href="https://phpstan.org/"><img src="https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat" alt="PHPStan Enabled"></a>
<a href="https://php.net/"><img src="https://img.shields.io/packagist/php-v/robiningelbrecht/continuous-integration-example/dev-master" alt="PHP"></a>
</p>

------

This repository aims to build a fairly complete <a href="https://en.wikipedia.org/wiki/CI/CD" target="_blanks">CI/CD</a> 
example using GitHub workflows and actions.

Keep in mind that the toolset used in this repository is not the only solution 
to build a solid workflow. I'm sure there are many tools I have never heard of 
that can get the job done as wel 🚀.

If you liked this tutorial, please consider giving it a ⭐

------

<h2>Setting up the repository</h2>

Before we get into the technical stuff, we first need to set up our repository.
The main thing we want to do is setting up the _default branch_
and the _branch protection rules_. 

<h3>The default branch</h3>

The default branch is considered the “base” branch in your repository, 
against which all pull requests and code commits are automatically made, 
unless you specify a different branch. 

You can configure the default branch by navigating to 
https://github.com/username/repository/settings/branches. You can set the default 
branch to whatever you want, but usually "_main_" or "_master_" are used.

<h3>Branch protection rules</h3>

<h2 align="center">Configuring CI/CD workflow</h2>
<h2 align="center">Configuring deploy workflow</h2>
