<? 
error_reporting(E_ALL);
if(isset($_POST["num"])){

if($_POST["num"]==0){
?>
SELECT mukey, cokey, comppct_r, taxorder, taxsuborder, taxgrtgroup, taxsubgrp, compname, pm.pmgroupname, pm.rvindicator, pm.pmkind
FROM
component
LEFT JOIN
        (
        -- get parent material data for each cokey
        SELECT cokey, pmorder, pmmodifier, pmgenmod, pmgroupname, rvindicator, pmkind
        FROM copmgrp
        LEFT JOIN copm USING (copmgrpkey)
        ) AS pm
USING (cokey)
WHERE mukey = '461573' ;
<? }elseif($_POST["num"]==1){ ?>
SELECT mukey, cokey, comppct_r, compname, taxorder
FROM component
WHERE majcompflag = 'Yes' AND mukey IN ('462043', '462068')
ORDER BY mukey, comppct_r DESC ;
<? }elseif($_POST["num"]==2){ ?>
SELECT cokey, majcompflag, comppct_r, wei, weg, tfact
FROM component
WHERE mukey = '467038'
ORDER BY comppct_r DESC;
<? }elseif($_POST["num"]==3){ ?>
SELECT  hzname AS name, hzdepb_r - hzdept_r AS thickness, sandtotal_r AS sand, silttotal_r AS silt, claytotal_r AS clay, awc_r AS awc
FROM chorizon
WHERE cokey = '467038:646635'
ORDER BY hzdept_r;
<? }elseif($_POST["num"]==4){ ?>
SELECT mapunit.mukind, round(avg(n_components)) AS avg, min(n_components), max(n_components)
FROM mapunit JOIN
        (
        SELECT mapunit.mukey, count(component.mukey) AS n_components
        FROM
        mapunit JOIN component
        ON mapunit.mukey = component.mukey
        WHERE component.majcompflag = 'Yes' AND mapunit.mukind IS NOT NULL
        GROUP BY mapunit.mukey
        ) AS a
ON a.mukey = mapunit.mukey
GROUP BY mapunit.mukind ;
<? } ?>
<? } ?>
