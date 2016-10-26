# -*- coding: utf-8 -*-

# -- General configuration ------------------------------------------------

extensions = []
templates_path = ['_templates']
source_suffix = '.rst'
master_doc = 'index'

project = u'UnderQuery'
copyright = u'2016, Beniamin Jonatan Šimko'
author = u'Beniamin Jonatan Šimko'

version = u'0.5.0'
release = u'0.5.0'
language = None

exclude_patterns = ['_build', 'Thumbs.db', '.DS_Store']
pygments_style = 'sphinx'
todo_include_todos = False

# -- Options for HTML output ----------------------------------------------

html_theme = 'default'
html_static_path = ['_static']
htmlhelp_basename = 'UnderQuerydoc'

# -- Options for LaTeX output ---------------------------------------------

latex_elements = {}
latex_documents = [
    (master_doc, 'UnderQuery.tex', u'UnderQuery Documentation',
     u'Beniamin Jonatan Šimko', 'manual'),
]

# -- Options for manual page output ---------------------------------------

man_pages = [
    (master_doc, 'underquery', u'UnderQuery Documentation',
     [author], 1)
]

# -- Options for Texinfo output -------------------------------------------

texinfo_documents = [
    (master_doc, 'UnderQuery', u'UnderQuery Documentation',
     author, 'UnderQuery', 'One line description of project.',
     'Miscellaneous'),
]

# -- PHP Support ----------------------------------------------------------

from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer

lexers['php'] = PhpLexer(startinline=True)
lexers['php-annotations'] = PhpLexer(startinline=True)