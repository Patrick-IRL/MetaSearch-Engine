<?php

error_reporting(0);

// Read the contents of the .html file into a string.
include 'includes/header.php';
include 'includes/navbar_abt.html';
?>
<div style="text-align:left">

<h3>About MetaSearch</h3>

<p>MetaSearch is a type of search tool, which is used to find information on the subjects a user submits. What makes MetaSearch different to other search engines like Google or Bing, is that it sends user requests to several other search engines and aggregates the results into a single list, or it can also display them according to their source</p>

<p>Why perform a search in this way? The reason a MetaSearch engine is effective is because the internet is so vast that no single engine can possibly produce perfect results all the time. They may miss some pages that are relevant to your search, and also may return some that are not relevant. By combining results from multiple search engines, we increase the chances of getting more relevant documents. The results are also ranked according to how many search engines returned a page, and what ranking each of those engines gave it, so that the most relevant pages are displayed first.</p>

<p>This MetaSearch website was built by <span class="text-success"><strong>Patrick Moorehouse</strong></span>. The site is part of a project for his M.Sc in Computer Science course.</p>

<h3>Key Terms</h3>

<p>Here are some of the key terms commonly used throughout this website.</p>

<!-- Accordian stlye collapsible menus -->
<div class="accordion" id="accordion2">
<div class="accordion-group">
<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
<h5>Searching</h5>
</a>
</div>
<div id="collapseOne" class="accordion-body collapse">
<div class="accordion-inner">
<p><span class="text-info">Aggregated: </span>Displays a single list of the combined and ranked results returned from multiple search engines.</p>

<p><span class="text-info">Non-Aggregated: </span>Displays separate lists of results for each search engine.</p>

<p><span class="text-info">Query Expansion: </span>Allows the user the option of loading alternative search terms to help refine and improve their query. Provides a list of synonyms and similar words or phrases, from which the user may choose one to add to the search.</p>

<p><span class="text-info">Complex Searches: </span>Allows the user more control over their searches by adding Boolean expressions to their query. By default AND is assumed, for example Programming Courses is interpreted as Programming AND Courses. The user can specify the NOT keyword, to search for terms but exclude others, for example Programming NOT Courses will display Programming related results, but will try to exclude any that are related to college or online courses etc. A user can search for pages that contain some expressions OR other expressions. For example, C++ OR PHP will return results that contain either C++ or PHP, but will try to exclude results containing both.</p>
</div>
</div>
</div>
<div class="accordion-group">
<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
<h5>Evaluation</h5>
</a>
</div>
<div  id="collapseTwo" class="accordion-body collapse">
<div class="accordion-inner">
<p><span class="text-info">Existing Results: </span>Loads a web page with performance results which were acquired previously. This is just a static example of the performance scores of the aggregation engine or the separate search engines.</p>

<p><span class="text-info">New Evaluation: </span>Performs a new evaluation, and displays the newly acquired results. This includes sending 50 different pre-determined queries to each of the search engines used by MetaSearch, calculating the performance scores of each engine for each query, and then calculating some average scores for each engine across all 50 queries. This process sends and receives a large amount of data, and due to the restrictions imposed by the individual search engines used by MetaSearch, an authorisation password will be required to run this kind of evaluation.</p>

<p><span class="text-info">RRF Score: </span>Reciprocal Rank Fusion score. This is the method by which pages are ranked in the aggregated list. When a search engine returns a set of documents, each document is assigned a score. The Reciprocal Ranked Fusion score of a document, d, from a collection of documents, D, is</p>
<img src="img/RRF3.png" alt="rrf equation" />
<p>where k is a constant, and r is the document's rank assigned by each of the search engines. For more information see <a href="http://plg.uwaterloo.ca/~gvcormac/cormacksigir09-rrf.pdf">this paper</a></p>
</div>
</div>
</div>
<div class="accordion-group">
<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
<h5>Evaluation Metrics</h5>
</a>
</div>
<div id="collapseThree" class="accordion-body collapse">
<div class="accordion-inner">


<p>These are some of the various evaluation metrics used to assess how well a search engine performs.</p>

<div class="row-fluid">
<div class="span6">
<p><span class="text-info">Retrieved: </span>The number of documents returned by an engine.</p>

<p><span class="text-info">Relevant: </span>The total number of documents available that are relevant to the search query.</p>

<p><span class="text-info">Precision: </span>The number of relevant documents returned by an engine divided by the total number of documents returned. This is a measure of how many of an engines returned pages are relevant to the query.</p>

<p><span class="text-info">Recall: </span>The number of relevant documents returned by an engine divided by the total number of relevant documents. This is a measure of how many of the total number of relevant documents are actually returned by the engine.</p>
</div>

<div class="span6">
<p><span class="text-info">Average Precision: </span>This is the precision calculated at each point where a relevant document is retrieved, and then averaged over all of the results for that query.</p>

<p><span class="text-info">F-Measure: </span>Two times the Recall multiplied by the Precision, divided by the Recall added to the Precision. 2RP / R+P. This is a measure of the trade-off between recall and precision. An engine with both high precision and high recall will have a high F-Measure. If one is high and one is low, the F-Measure will be lower.</p>

<p><span class="text-info">Mean Average Precision (MAP): </span>Simply the mean of the Average Precision for multiple queries. The AP for each query is summed, then divided by the number of queries.</p>
</div>

</div> <!-- /row-fluid -->
</div>
</div>
</div>
</div>
            

<!-- /collapsible region -->  



</div> <!-- /container left align -->

<script src="js/bootstrap.js"></script>
<script src="js/jquery.js"></script>

<?php
include 'includes/footer.html';
?> 
