<%@ page session="true" contentType="text/html; charset=UTF-8" %>
<%@ taglib uri="http://www.tonbeller.com/jpivot" prefix="jp" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jstl/core" %>

<jp:mondrianQuery id="query01"
    jdbcDriver="com.mysql.jdbc.Driver"
    jdbcUrl="jdbc:mysql://localhost/uasdwo?user=root&password="
    catalogUri="/WEB-INF/queries/mondrianuas.xml"
    jdbcUser="root"
    jdbcPassword="">

    <!-- MDX Query -->
    select 
        {[Measures].[Total Penjualan]} on columns,
        {
            ([Tahun].[Tahun].[Nama Tahun].Members, [Wilayah].[Semua Wilayah], [Produk].[Semua Produk], [Customer].[Semua Customer]) 
        } on rows
    from [Sales]
    
</jp:mondrianQuery>

<!-- Display a session variable for the title -->
<c:set var="title01" scope="session">Sales Cube</c:set>

<h2>${title01}</h2>

<!-- Optionally display the result as a pivot table -->
<jp:mondrianPivotTable queryId="query01" />
