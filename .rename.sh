find ./ -type f -exec sed -i -e 's|Disciple_Tools_Three_Thirds|Disciple_Tools_Three_Thirds|g' {} \;
find ./ -type f -exec sed -i -e 's|disciple_tools_three_thirds|disciple_tools_three_thirds|g' {} \;
find ./ -type f -exec sed -i -e 's|disciple-tools-three-thirds|disciple-tools-three-thirds|g' {} \;
find ./ -type f -exec sed -i -e 's|starter_post_type|starter_post_type|g' {} \;
find ./ -type f -exec sed -i -e 's|3/3rds Meetings|3/3rds Meetings|g' {} \;
mv disciple-tools-three-thirds.php disciple-tools-three-thirds.php
rm .rename.sh
